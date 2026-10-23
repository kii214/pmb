/**
 * Registration Sidebar Vue 3 Component — PMB STMIK ROSMA
 * Animated sidebar with floating icons, countdown timer, and step tracker
 */
(function () {
    const mountEl = document.getElementById('regSidebar');
    if (!mountEl || mountEl.__vue_app__) return;

    const { createApp, ref, onMounted } = Vue;

    // Read data from data attributes
    const waveName  = mountEl.dataset.waveName  || 'Gelombang Aktif';
    const waveStart = mountEl.dataset.waveStart || '';
    const waveEnd   = mountEl.dataset.waveEnd   || '';
    const waveYear  = mountEl.dataset.waveYear  || '';

    const RegSidebarApp = createApp({
        setup() {
            const step      = ref(1);
            const countdown = ref({ d: 0, h: 0, m: 0, s: 0 });

            const orbs = [
                { emoji: '🎓', x: 14, y: 8,  sz: 46, delay: 0   },
                { emoji: '💻', x: 72, y: 12, sz: 34, delay: 0.7 },
                { emoji: '📚', x: 82, y: 55, sz: 28, delay: 1.4 },
                { emoji: '🏛️', x: 6,  y: 62, sz: 32, delay: 1.0 },
                { emoji: '⭐', x: 50, y: 78, sz: 24, delay: 1.8 },
            ];

            const steps = [
                { icon: 'bi-person-vcard',  label: 'Data Pribadi',   sub: 'Informasi dasar' },
                { icon: 'bi-building',      label: 'Pendidikan',     sub: 'Asal sekolah' },
                { icon: 'bi-mortarboard',   label: 'Program & Info', sub: 'Jalur, Prodi & Selesai' },
            ];

            function pad(n) { return String(n).padStart(2, '0'); }

            function startCountdown() {
                if (!waveEnd) return;
                const parts  = waveEnd.split(' ');
                const months = { 'Jan':0,'Feb':1,'Mar':2,'Apr':3,'Mei':4,'May':4,'Jun':5,'Jul':6,'Agt':7,'Agu':7,'Aug':7,'Sep':8,'Okt':9,'Oct':9,'Nov':10,'Des':11,'Dec':11 };
                const day = parseInt(parts[0]);
                const mon = months[parts[1]] ?? 0;
                const yr  = parseInt(parts[2]);
                const end = new Date(yr, mon, day, 23, 59, 59);
                const update = () => {
                    const diff = end - new Date();
                    if (diff <= 0) { countdown.value = { d:0,h:0,m:0,s:0 }; return; }
                    countdown.value.d = Math.floor(diff / 86400000);
                    countdown.value.h = Math.floor((diff % 86400000) / 3600000);
                    countdown.value.m = Math.floor((diff % 3600000) / 60000);
                    countdown.value.s = Math.floor((diff % 60000) / 1000);
                    setTimeout(update, 1000);
                };
                update();
            }

            onMounted(() => {
                startCountdown();
                // Listen for step changes from the form nextStep/prevStep functions
                mountEl.addEventListener('setstep', (e) => {
                    step.value = e.detail;
                });
            });

            return { step, countdown, orbs, steps, waveName, waveStart, waveEnd, waveYear, pad };
        },

        template: `
<div style="display:flex;flex-direction:column;height:100%;padding:26px 22px 22px;">

  <!-- Logo & Title -->
  <div style="text-align:center;margin-bottom:22px;">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:52px;height:52px;background:rgba(255,255,255,.1);border-radius:13px;border:1px solid rgba(255,255,255,.15);margin-bottom:9px;">
      <span style="font-size:1.45rem;">🏛️</span>
    </div>
    <div style="color:#fff;font-weight:800;font-size:.95rem;line-height:1.2;">STMIK ROSMA</div>
    <div style="color:rgba(255,255,255,.45);font-size:.67rem;letter-spacing:1px;text-transform:uppercase;margin-top:2px;">Pendaftaran Online</div>
  </div>

  <!-- Floating orbs box -->
  <div style="position:relative;height:118px;border-radius:11px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);overflow:hidden;margin-bottom:18px;">
    <div v-for="(o,i) in orbs" :key="i"
      :style="{position:'absolute',left:o.x+'%',top:o.y+'%',fontSize:o.sz+'px',animation:'regFloat 3.5s ease-in-out infinite',animationDelay:o.delay+'s',filter:'drop-shadow(0 2px 5px rgba(0,0,0,.25))',lineHeight:'1'}">
      {{ o.emoji }}
    </div>
    <div style="position:absolute;bottom:8px;left:0;right:0;text-align:center;color:rgba(255,255,255,.3);font-size:.62rem;letter-spacing:1px;text-transform:uppercase;">
      Formulir Pendaftaran Online
    </div>
  </div>

  <!-- Steps tracker -->
  <div style="flex:1;">
    <div style="color:rgba(255,255,255,.4);font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:9px;">Langkah Pendaftaran</div>
    <div v-for="(s,i) in steps" :key="i"
      :style="{
        display:'flex', alignItems:'center', gap:'11px', padding:'9px 11px',
        borderRadius:'8px', marginBottom:'5px', transition:'all .25s ease',
        background: step===i+1 ? 'rgba(255,255,255,.12)' : 'transparent',
        border: step===i+1 ? '1px solid rgba(255,255,255,.18)' : '1px solid transparent',
      }">
      <div :style="{
        width:'31px', height:'31px', borderRadius:'8px', flexShrink:0,
        display:'flex', alignItems:'center', justifyContent:'center',
        background: step>i+1 ? '#16a34a' : step===i+1 ? 'rgba(255,255,255,.18)' : 'rgba(255,255,255,.06)',
        border: '1px solid '+(step===i+1 ? 'rgba(255,255,255,.28)' : 'rgba(255,255,255,.08)'),
        transition:'all .3s ease',
      }">
        <i v-if="step>i+1" class="bi bi-check-lg" style="color:#fff;font-size:.82rem;"></i>
        <i v-else :class="'bi '+s.icon" style="color:rgba(255,255,255,.72);font-size:.82rem;"></i>
      </div>
      <div>
        <div :style="{color:step===i+1?'#fff':'rgba(255,255,255,.48)',fontWeight:step===i+1?'700':'500',fontSize:'.8rem',lineHeight:'1.2'}">{{ s.label }}</div>
        <div style="color:rgba(255,255,255,.28);font-size:.66rem;">{{ s.sub }}</div>
      </div>
      <div v-if="step===i+1" style="margin-left:auto;width:6px;height:6px;background:#fbbf24;border-radius:50%;"></div>
    </div>
  </div>

  <!-- Bottom -->
  <div style="margin-top:10px;text-align:center;color:rgba(255,255,255,.22);font-size:.63rem;">
    pmb.rosma.ac.id · Pendaftaran Aman &amp; Terpercaya
  </div>
</div>
        `
    });

    RegSidebarApp.mount('#regSidebar');

    // Expose step setter for nextStep/prevStep functions
    window._regSidebarApp = RegSidebarApp;
})();
