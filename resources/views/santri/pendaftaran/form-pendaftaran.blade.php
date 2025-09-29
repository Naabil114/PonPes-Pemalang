<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pendaftaran Santri</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* --- KEMBALIKAN STYLE (mengikuti style yang kamu minta sebelumnya) --- */
        :root {
            --primary-color: #2c5f2d;
            --secondary-color: #97bc62;
            --accent-color: #ffd700;
            --dark-green: #1a3a1b;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 10px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .registration-container { animation: fadeInUp 0.6s ease-out; }
        @keyframes fadeInUp { from { opacity:0; transform: translateY(30px);} to {opacity:1; transform: translateY(0);} }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-green) 100%);
            color: white;
            padding: 20px;
            border: none;
            position: relative;
            overflow: hidden;
        }
        .card-header h2 { margin:0; font-weight:700; font-size:1.25rem; display:flex; align-items:center; justify-content:center; gap:10px; }
        .card-body { padding: 20px 15px; }

        .progress { height: 8px; border-radius: 10px; background-color: #e9ecef; overflow: visible; }
        .progress-bar { background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%); border-radius: 10px; transition: width .5s ease; }

        .step { display:none; animation: slideIn .4s ease-out; }
        .step.active { display:block; }
        @keyframes slideIn { from{opacity:0; transform:translateX(20px);} to {opacity:1; transform:translateX(0);} }

        .step h4 { color: var(--dark-green); font-weight:700; margin-bottom:20px; padding-bottom:12px; border-bottom:3px solid var(--secondary-color); display:flex; align-items:center; gap:8px; }

        .form-label { font-weight:600; color:#495057; margin-bottom:8px; display:flex; align-items:center; gap:8px; }
        .form-control, .form-select { border:2px solid #e0e0e0; border-radius:10px; padding:10px 12px; font-size:0.95rem; transition: all .3s ease; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(44,95,45,.15); }

        .invalid-feedback { font-size:0.875rem; margin-top:5px; color:#d6333e; }

        .steps-indicator { display:flex; align-items:center; justify-content:center; margin:20px 0; gap:8px; }
        .step-item { display:flex; flex-direction:column; align-items:center; position:relative; z-index:1; }
        .step-circle { width:50px; height:50px; border-radius:50%; background:#e9ecef; border:3px solid #dee2e6; display:flex; align-items:center; justify-content:center; font-size:1.2rem; color:#6c757d; transition:all .3s ease; margin-bottom:8px; }
        .step-item.active .step-circle { background: linear-gradient(135deg,var(--primary-color) 0%,var(--dark-green) 100%); color:white; transform:scale(1.1); box-shadow:0 4px 15px rgba(44,95,45,.4); }
        .step-item.completed .step-circle { background:var(--secondary-color); color:white; }
        .step-label { font-size:0.75rem; font-weight:600; color:#6c757d; text-align:center; margin-top:5px; }
        .step-line { width:80px; height:3px; background:#dee2e6; position:relative; margin-bottom:30px; }
        .step-line::after { content:''; position:absolute; left:0; top:0; height:100%; width:0%; background: linear-gradient(90deg,var(--primary-color) 0%,var(--secondary-color) 100%); transition:width .5s ease; }
        .step-line.active::after { width:100%; }

        @media (max-width:768px){ .step-line{ width:50px; } .step-circle{ width:45px; height:45px;} }
    </style>
</head>
<body>
    @php
        // Tentukan initial step berdasarkan old('current_step') atau error yang muncul
        $initialStep = old('current_step', 1);

        if ($errors->any()) {
            // step 1 fields
            $step1 = ['nama_santri','tempat_lahir','tanggal_lahir','jenis_kelamin','alamat'];
            // step 2 fields
            $step2 = ['nama_orang_tua','no_telp'];
            // step 3 fields
            $step3 = ['file_kk','file_akta_kelahiran','file_ijazah_sd','file_skhu_sd','file_pas_foto','file_ktp_ortu'];

            foreach ($step1 as $f) { if ($errors->has($f)) { $initialStep = 1; break; } }
            foreach ($step2 as $f) { if ($errors->has($f)) { $initialStep = 2; break; } }
            foreach ($step3 as $f) { if ($errors->has($f)) { $initialStep = 3; break; } }
        }
    @endphp

    <div class="container mt-3 mt-md-5 registration-container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center"><span>Pendaftaran Santri</span></h2>
                    </div>

                    <div class="card-body">
                        <!-- progress -->
                        <div class="progress mb-4">
                            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- steps indicator -->
                        <div class="steps-indicator mb-4">
                            <div class="step-item" data-step="1">
                                <div class="step-circle"><i class="fas fa-user"></i></div>
                                <div class="step-label">Data Pribadi</div>
                            </div>
                            <div class="step-line"></div>

                            <div class="step-item" data-step="2">
                                <div class="step-circle"><i class="fas fa-users"></i></div>
                                <div class="step-label">Data Orang Tua</div>
                            </div>
                            <div class="step-line"></div>

                            <div class="step-item" data-step="3">
                                <div class="step-circle"><i class="fas fa-file-upload"></i></div>
                                <div class="step-label">Upload Berkas</div>
                            </div>
                        </div>

                        <!-- form -->
                        <form id="registrationForm"
                              action="{{ route('santri.pendaftaran.submit') }}"
                              method="POST"
                              class="needs-validation"
                              novalidate
                              enctype="multipart/form-data">
                            @csrf

                            {{-- simpan current step supaya saat redirect back kita bisa menampilkan step yang sama --}}
                            <input type="hidden" name="current_step" id="current_step" value="{{ old('current_step', $initialStep) }}">

                            <!-- STEP 1 -->
                            <div class="step" id="step1">
                                <h4><i class="fas fa-user-circle"></i> Data Pribadi</h4>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_santri" class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                                        <input type="text"
                                               class="form-control {{ $errors->has('nama_santri') ? 'is-invalid' : (old('nama_santri') ? 'is-valid':'' ) }}"
                                               id="nama_santri"
                                               name="nama_santri"
                                               placeholder="Masukkan nama lengkap"
                                               value="{{ old('nama_santri') }}"
                                               required>
                                        @if($errors->has('nama_santri'))
                                            <div class="invalid-feedback">{{ $errors->first('nama_santri') }}</div>
                                        @else
                                            <div class="invalid-feedback">Harap masukkan nama lengkap.</div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="tempat_lahir" class="form-label"><i class="fas fa-map-marker-alt"></i> Tempat Lahir</label>
                                        <input type="text"
                                               class="form-control {{ $errors->has('tempat_lahir') ? 'is-invalid' : (old('tempat_lahir') ? 'is-valid':'' ) }}"
                                               id="tempat_lahir"
                                               name="tempat_lahir"
                                               placeholder="Masukkan tempat lahir"
                                               value="{{ old('tempat_lahir') }}"
                                               required>
                                        @if($errors->has('tempat_lahir'))
                                            <div class="invalid-feedback">{{ $errors->first('tempat_lahir') }}</div>
                                        @else
                                            <div class="invalid-feedback">Harap masukkan tempat lahir.</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_lahir" class="form-label"><i class="fas fa-calendar"></i> Tanggal Lahir</label>
                                        <input type="date"
                                               class="form-control {{ $errors->has('tanggal_lahir') ? 'is-invalid' : (old('tanggal_lahir') ? 'is-valid':'' ) }}"
                                               id="tanggal_lahir"
                                               name="tanggal_lahir"
                                               value="{{ old('tanggal_lahir') }}"
                                               required>
                                        @if($errors->has('tanggal_lahir'))
                                            <div class="invalid-feedback">{{ $errors->first('tanggal_lahir') }}</div>
                                        @else
                                            <div class="invalid-feedback">Harap pilih tanggal lahir.</div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_kelamin" class="form-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                        <select class="form-select {{ $errors->has('jenis_kelamin') ? 'is-invalid' : (old('jenis_kelamin') ? 'is-valid':'' ) }}"
                                                id="jenis_kelamin"
                                                name="jenis_kelamin"
                                                required>
                                            <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih...</option>
                                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @if($errors->has('jenis_kelamin'))
                                            <div class="invalid-feedback">{{ $errors->first('jenis_kelamin') }}</div>
                                        @else
                                            <div class="invalid-feedback">Harap pilih jenis kelamin.</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label"><i class="fas fa-home"></i> Alamat</label>
                                    <textarea class="form-control {{ $errors->has('alamat') ? 'is-invalid' : (old('alamat') ? 'is-valid':'' ) }}"
                                              id="alamat"
                                              name="alamat"
                                              rows="3"
                                              placeholder="Masukkan alamat lengkap"
                                              required>{{ old('alamat') }}</textarea>
                                    @if($errors->has('alamat'))
                                        <div class="invalid-feedback">{{ $errors->first('alamat') }}</div>
                                    @else
                                        <div class="invalid-feedback">Harap masukkan alamat.</div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" onclick="goToStep(2)">Selanjutnya <i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            <!-- STEP 2 -->
                            <div class="step" id="step2">
                                <h4><i class="fas fa-users"></i> Data Orang Tua/Wali</h4>

                                <div class="mb-3">
                                    <label for="nama_orang_tua" class="form-label"><i class="fas fa-user-tie"></i> Nama Orang Tua/Wali</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('nama_orang_tua') ? 'is-invalid' : (old('nama_orang_tua') ? 'is-valid':'' ) }}"
                                           id="nama_orang_tua"
                                           name="nama_orang_tua"
                                           placeholder="Masukkan nama orang tua atau wali"
                                           value="{{ old('nama_orang_tua') }}"
                                           required>
                                    @if($errors->has('nama_orang_tua'))
                                        <div class="invalid-feedback">{{ $errors->first('nama_orang_tua') }}</div>
                                    @else
                                        <div class="invalid-feedback">Harap masukkan nama orang tua/wali.</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="no_telp" class="form-label"><i class="fas fa-phone"></i> Nomor Telepon</label>
                                    <input type="tel"
                                           inputmode="tel"
                                           class="form-control {{ $errors->has('no_telp') ? 'is-invalid' : (old('no_telp') ? 'is-valid':'' ) }}"
                                           id="no_telp"
                                           name="no_telp"
                                           placeholder="08xxxxxxxxxx"
                                           maxlength="13"
                                           value="{{ old('no_telp') }}"
                                           required>
                                    @if($errors->has('no_telp'))
                                        <div class="invalid-feedback">{{ $errors->first('no_telp') }}</div>
                                    @else
                                        <div class="invalid-feedback">Harap masukkan nomor telepon yang valid.</div>
                                    @endif
                                    <small class="text-muted">Nomor ini akan menjadi username & password default.</small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="goToStep(1)"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                                    <button type="button" class="btn btn-primary" onclick="goToStep(3)">Selanjutnya <i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            <!-- STEP 3 -->
                            <div class="step" id="step3">
                                <h4><i class="fas fa-file-upload"></i> Upload Berkas Pendaftaran</h4>

                                <div class="mb-3">
                                    <label for="file_kk" class="form-label"><i class="fas fa-users"></i> Kartu Keluarga (pdf/jpg/png)</label>
                                    <input type="file" class="form-control {{ $errors->has('file_kk') ? 'is-invalid' : '' }}" id="file_kk" name="file_kk" accept=".pdf,.jpg,.jpeg,.png" {{ old('file_kk') ? '' : 'required' }}>
                                    @if($errors->has('file_kk'))
                                        <div class="invalid-feedback">{{ $errors->first('file_kk') }}</div>
                                    @else
                                        <div class="invalid-feedback">Harap unggah file KK.</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="file_akta_kelahiran" class="form-label"><i class="fas fa-file-alt"></i> Akta Kelahiran (pdf/jpg/png)</label>
                                    <input type="file" class="form-control {{ $errors->has('file_akta_kelahiran') ? 'is-invalid' : '' }}" id="file_akta_kelahiran" name="file_akta_kelahiran" accept=".pdf,.jpg,.jpeg,.png" {{ old('file_akta_kelahiran') ? '' : 'required' }}>
                                    @if($errors->has('file_akta_kelahiran'))
                                        <div class="invalid-feedback">{{ $errors->first('file_akta_kelahiran') }}</div>
                                    @else
                                        <div class="invalid-feedback">Harap unggah akta kelahiran.</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="file_ijazah_sd" class="form-label"><i class="fas fa-graduation-cap"></i> Ijazah SD (pdf/jpg/png) — jika ada</label>
                                    <input type="file" class="form-control {{ $errors->has('file_ijazah_sd') ? 'is-invalid' : '' }}" id="file_ijazah_sd" name="file_ijazah_sd" accept=".pdf,.jpg,.jpeg,.png">
                                    @if($errors->has('file_ijazah_sd'))
                                        <div class="invalid-feedback">{{ $errors->first('file_ijazah_sd') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="file_skhu_sd" class="form-label"><i class="fas fa-certificate"></i> SKHU SD (pdf/jpg/png) — jika ada</label>
                                    <input type="file" class="form-control {{ $errors->has('file_skhu_sd') ? 'is-invalid' : '' }}" id="file_skhu_sd" name="file_skhu_sd" accept=".pdf,.jpg,.jpeg,.png">
                                    @if($errors->has('file_skhu_sd'))
                                        <div class="invalid-feedback">{{ $errors->first('file_skhu_sd') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="file_pas_foto" class="form-label"><i class="fas fa-image"></i> Pas Foto (jpg/png)</label>
                                    <input type="file" class="form-control {{ $errors->has('file_pas_foto') ? 'is-invalid' : '' }}" id="file_pas_foto" name="file_pas_foto" accept="image/*" {{ old('file_pas_foto') ? '' : 'required' }}>
                                    @if($errors->has('file_pas_foto'))
                                        <div class="invalid-feedback">{{ $errors->first('file_pas_foto') }}</div>
                                    @else
                                        <div class="invalid-feedback">Harap unggah pas foto.</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="file_ktp_ortu" class="form-label"><i class="fas fa-id-card"></i> KTP Orang Tua/Wali (pdf/jpg/png)</label>
                                    <input type="file" class="form-control {{ $errors->has('file_ktp_ortu') ? 'is-invalid' : '' }}" id="file_ktp_ortu" name="file_ktp_ortu" accept=".pdf,.jpg,.jpeg,.png" {{ old('file_ktp_ortu') ? '' : 'required' }}>
                                    @if($errors->has('file_ktp_ortu'))
                                        <div class="invalid-feedback">{{ $errors->first('file_ktp_ortu') }}</div>
                                    @else
                                        <div class="invalid-feedback">Harap unggah KTP orang tua/wali.</div>
                                    @endif
                                </div>

                                <div class="alert alert-info small">Catatan: Jika validasi server gagal, browser tidak menyimpan file input — mohon unggah ulang berkas yang diminta.</div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="goToStep(2)"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check me-2"></i> Selesai & Kirim</button>
                                </div>
                            </div>

                        </form>
                        <!-- end form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- bootstrap bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // initial step from server-side (Blade variable)
        let currentStep = parseInt({{ $initialStep }});
        const totalSteps = 3;

        // track touched fields for nicer UX (do not override server classes)
        const touched = new WeakSet();

        document.addEventListener('DOMContentLoaded', () => {
            initFieldListeners();

            // mark server-side invalid fields as touched so their UI stays visible
            document.querySelectorAll('.is-invalid').forEach(f => touched.add(f));

            // set hidden current_step input
            const currentStepInput = document.getElementById('current_step');
            if (currentStepInput) currentStepInput.value = currentStep;

            showStep(currentStep);
        });

        function initFieldListeners() {
            const fields = document.querySelectorAll('#registrationForm input, #registrationForm select, #registrationForm textarea');
            fields.forEach(field => {
                if (field.type === 'file') {
                    field.addEventListener('change', () => {
                        touched.add(field);
                        updateFieldUI(field, true);
                    });
                } else {
                    field.addEventListener('input', () => {
                        touched.add(field);
                        updateFieldUI(field, false);
                    });
                    field.addEventListener('blur', () => {
                        touched.add(field);
                        updateFieldUI(field, true);
                    });
                }
            });
        }

        function updateFieldUI(field, forceShow) {
            const valid = isFieldValid(field);
            if (forceShow || touched.has(field)) {
                if (valid) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                } else {
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                }
            }
        }

        function isFieldValid(field) {
            if (field.type === 'file') {
                if (!field.hasAttribute('required')) return true;
                return field.files && field.files.length > 0;
            }
            if (typeof field.checkValidity === 'function') {
                return field.checkValidity();
            }
            return field.value && field.value.toString().trim() !== '';
        }

        function showStep(step) {
            document.querySelectorAll('.step').forEach((el, idx) => {
                el.classList.toggle('active', (idx + 1) === step);
            });

            // progress
            const percent = Math.round((step / totalSteps) * 100);
            const pb = document.getElementById('progressBar');
            if (pb) pb.style.width = percent + '%';

            // indicators
            document.querySelectorAll('.step-item').forEach((item, idx) => {
                item.classList.remove('active', 'completed');
                if (idx + 1 < step) item.classList.add('completed');
                if (idx + 1 === step) item.classList.add('active');
            });
            document.querySelectorAll('.step-line').forEach((line, idx) => {
                if (idx < step - 1) line.classList.add('active'); else line.classList.remove('active');
            });

            // update hidden current_step input
            const currentStepInput = document.getElementById('current_step');
            if (currentStepInput) currentStepInput.value = step;

            // scroll to top
            window.scrollTo({ top: document.querySelector('.card').offsetTop - 20, behavior: 'smooth' });
        }

        function goToStep(targetStep) {
            // when moving forward, validate current step
            if (targetStep > currentStep) {
                if (!validateStep(currentStep)) {
                    return;
                }
            }
            currentStep = targetStep;
            showStep(currentStep);
        }

        function validateStep(stepIndex) {
            const stepEl = document.getElementById('step' + stepIndex);
            if (!stepEl) return true;
            const requiredFields = stepEl.querySelectorAll('[required]');
            let valid = true;
            requiredFields.forEach(field => {
                // force show each field's validation
                updateFieldUI(field, true);
                if (!isFieldValid(field)) valid = false;
            });
            return valid;
        }

        // on submit: validate all steps and send; if any invalid, jump to first invalid
        const form = document.getElementById('registrationForm');
        form.addEventListener('submit', function (e) {
            let allValid = true;
            let firstInvalidStep = null;
            for (let s = 1; s <= totalSteps; s++) {
                const ok = validateStep(s);
                if (!ok) {
                    allValid = false;
                    if (firstInvalidStep === null) firstInvalidStep = s;
                }
            }
            if (!allValid) {
                e.preventDefault();
                currentStep = firstInvalidStep;
                showStep(currentStep);
                return false;
            }
            // else allow submit (server-side validation will run too)
        });
    </script>
</body>
</html>
