/**
 * Campus Highlights Vue 3 Component — PMB STMIK ROSMA
 * Interactive highlights panel with icons, tabs & animations
 */
(function () {
    const mountEl = document.getElementById('campusStatsApp');
    if (!mountEl || mountEl.__vue_app__) return;

    const { createApp, ref } = Vue;

    const CampusStatsApp = createApp({
        setup() {
            const activeTab = ref('features');

            const features = ref([
                {
                    icon: 'bi-mortarboard-fill',
                    title: 'Program Studi Unggulan',
                    desc: 'S1 & D3 Bidang Komputer Terakreditasi',
                    color: '#1a4480',
                    bg: '#e8f0fe'
                },
                {
                    icon: 'bi-patch-check-fill',
                    title: 'Terakreditasi Resmi',
                    desc: 'Status Akreditasi LAM-INFOKOM & BAN-PT',
                    color: '#16a34a',
                    bg: '#dcfce7'
                },
                {
                    icon: 'bi-clock-history',
                    title: 'Kelas Fleksibel',
                    desc: 'Tersedia Kelas Karyawan & Reguler',
                    color: '#c8940a',
                    bg: '#fef3c7'
                },
                {
                    icon: 'bi-briefcase-fill',
                    title: 'Kemitraan Industri',
                    desc: 'Jejaring Kawasan Industri Karawang',
                    color: '#0284c7',
                    bg: '#e0f2fe'
                },
            ]);

            const accreditations = [
                { name: 'Sistem Informasi (S1)',         grade: 'Baik Sekali', until: 'Des 2029', cls: 'baiksekali' },
                { name: 'Komputerisasi Akuntansi (D3)',  grade: 'Baik Sekali', until: 'Agt 2030', cls: 'baiksekali' },
                { name: 'Teknik Informatika (S1)',        grade: 'Baik',        until: 'Des 2028', cls: 'baik'       },
                { name: 'Manajemen Informatika (D3)',     grade: 'Baik',        until: '2027',     cls: 'baik'       },
            ];

            const orbs = [
                { emoji: '🎓', x: 10, y: 8,  sz: 46, delay: 0   },
                { emoji: '💻', x: 74, y: 5,  sz: 36, delay: 0.7 },
                { emoji: '🚀', x: 84, y: 52, sz: 30, delay: 1.4 },
                { emoji: '🏛️', x: 5,  y: 58, sz: 34, delay: 1.0 },
                { emoji: '⭐', x: 50, y: 80, sz: 26, delay: 1.8 },
            ];

            return { activeTab, features, accreditations, orbs };
        },

        template: `
<div class="csv-panel">
  <!-- Header bar -->
  <div class="csv-header">
    <div class="csv-dots">
      <span class="csv-dot csv-dot-r"></span>
      <span class="csv-dot csv-dot-y"></span>
      <span class="csv-dot csv-dot-g"></span>
    </div>
    <span class="csv-header-title">Keunggulan Kampus — STMIK ROSMA</span>
  </div>

  <!-- Body -->
  <div class="csv-body">

    <!-- Floating orbs area -->
    <div class="csv-orbs-area">
      <div v-for="(o,i) in orbs" :key="i" class="csv-orb"
        :style="{left:o.x+'%', top:o.y+'%', fontSize:o.sz+'px', animationDelay:o.delay+'s'}">
        {{ o.emoji }}
      </div>
      <div class="csv-orbs-label">Penerimaan Mahasiswa Baru · STMIK ROSMA</div>
    </div>

    <!-- Tab switcher -->
    <div class="csv-tabs">
      <button :class="['csv-tab', activeTab==='features' && 'csv-tab--active']" @click="activeTab='features'">
        ✨ Keunggulan
      </button>
      <button :class="['csv-tab', activeTab==='accr' && 'csv-tab--active']" @click="activeTab='accr'">
        🎖️ Akreditasi
      </button>
    </div>

    <!-- Features with Icons -->
    <transition name="csv-fade" mode="out-in">
    <div v-if="activeTab==='features'" key="features" class="csv-stats-grid">
      <div v-for="(f,i) in features" :key="i" class="csv-feature-card">
        <div class="csv-icon-bubble" :style="{background: f.bg, color: f.color}">
          <i :class="['bi', f.icon]"></i>
        </div>
        <div class="csv-feature-title">{{ f.title }}</div>
        <div class="csv-feature-desc">{{ f.desc }}</div>
      </div>
    </div>

    <!-- Accreditation -->
    <div v-else key="accr" class="csv-accr-list">
      <div class="csv-accr-header">✅ Status Akreditasi LAM-INFOKOM</div>
      <div v-for="(a,i) in accreditations" :key="i" class="csv-accr-row">
        <span :class="['csv-accr-badge','csv-accr-badge--'+a.cls]">{{ a.grade }}</span>
        <div class="csv-accr-info">
          <strong>{{ a.name }}</strong>
          <span>Berlaku s.d. {{ a.until }}</span>
        </div>
      </div>
    </div>
    </transition>

    <!-- Footer -->
    <div class="csv-footer">
      <span class="csv-live-dot"></span>
      PMB Aktif Tahun Akademik 2025/2026
      <span style="margin-left:auto;color:#9ca3af;font-size:.7rem;">pmb.rosma.ac.id</span>
    </div>
  </div>
</div>
        `
    });

    CampusStatsApp.mount('#campusStatsApp');
})();
