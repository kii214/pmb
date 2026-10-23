<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://penerimaan.rosma.ac.id/registrations/create");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36");
$html = curl_exec($ch);
curl_close($ch);

if (!$html) {
    die("Failed to fetch HTML.");
}

$dom = new DOMDocument();
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

$inputs = $xpath->query('//input | //select | //textarea');
foreach ($inputs as $input) {
    $name = $input->getAttribute('name');
    if (!$name || $name === '_token') continue;
    
    $type = $input->tagName;
    if ($type === 'input') {
        $type .= ' (type=' . $input->getAttribute('type') . ')';
    }
    
    $id = $input->getAttribute('id');
    
    // Find associated label
    $labelText = '';
    if ($id) {
        $labels = $xpath->query('//label[@for="'.$id.'"]');
        if ($labels->length > 0) {
            $labelText = trim($labels->item(0)->textContent);
        }
    }
    
    // Fallback: look for label containing the input or previous sibling
    if (!$labelText) {
        $parent = $input->parentNode;
        if ($parent && $parent->tagName === 'label') {
            $labelText = trim($parent->textContent);
        } else {
            $labels = $xpath->query('./preceding-sibling::label', $input);
            if ($labels->length > 0) {
                $labelText = trim($labels->item($labels->length - 1)->textContent);
            }
        }
    }
    
    echo "Field: $name\n";
    echo "Label: $labelText\n";
    echo "Type: $type\n";
    
    if ($input->tagName === 'select') {
        $options = $xpath->query('.//option', $input);
        echo "Options: ";
        $optVals = [];
        foreach ($options as $opt) {
            $val = trim($opt->textContent);
            if ($val) $optVals[] = $val;
        }
        echo implode(', ', $optVals) . "\n";
    }
    echo "--------------------------\n";
}
