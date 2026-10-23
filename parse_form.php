<?php
$html = file_get_contents('form_raw.html');
// Note: file_get_contents might read UTF-16LE, let's convert to UTF-8
if (mb_detect_encoding($html, 'UTF-16LE', true)) {
    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-16LE');
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
    
    // Fallback
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
    
    // clean up label (remove multiple spaces/newlines)
    $labelText = preg_replace('/\s+/', ' ', $labelText);
    
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
