@extends('layouts.app')
@section('content')
<style>
.rpg-topup-bg {
    position: fixed;
    inset: 0;
    z-index: -1;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 25%, #0f3460 50%, #1a1a2e 75%, #16213e 100%);
    background-size: 400% 400%;
    animation: backgroundShift 20s ease-in-out infinite;
}
.rpg-topup-bg::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(2px 2px at 20px 30px, rgba(255,193,7,0.4), transparent),
        radial-gradient(2px 2px at 40px 70px, rgba(59,130,246,0.3), transparent),
        radial-gradient(1px 1px at 90px 40px, rgba(147,51,234,0.4), transparent),
        radial-gradient(1px 1px at 130px 80px, rgba(34,197,94,0.3), transparent),
        radial-gradient(2px 2px at 160px 30px, rgba(239,68,68,0.3), transparent);
    background-repeat: repeat;
    background-size: 200px 100px;
    animation: floatingStars 25s linear infinite;
    pointer-events: none;
    z-index: 1;
}
@keyframes backgroundShift {
    0%, 100% { background-position: 0% 50%; }
    25% { background-position: 100% 50%; }
    50% { background-position: 100% 100%; }
    75% { background-position: 0% 100%; }
}
@keyframes floatingStars {
    0% { transform: translateY(0px) translateX(0px); }
    25% { transform: translateY(-10px) translateX(5px); }
    50% { transform: translateY(0px) translateX(-5px); }
    75% { transform: translateY(5px) translateX(5px); }
    100% { transform: translateY(0px) translateX(0px); }
}
</style>
<div class="rpg-topup-bg"></div>
<div class="container pt-3 d-flex flex-column justify-content-center align-items-center">
    <div class="d-flex flex-column align-items-center mb-4" style="width:100%;">
        <h2 class="rpg-title text-center" style="color:#ffd700; font-family:'Cinzel',serif; letter-spacing:2px; text-shadow:0 2px 8px #6a5acd;">{{ __('topup.top_up') }}</h2>
        <div style="height:4px; width:80px; background:linear-gradient(90deg,#ffd700,#6a5acd); border-radius:2px;"></div>
    </div>
    <div class="rpg-card shadow-lg p-4" style="background:rgba(34,30,60,0.95); border-radius:18px; max-width:420px; width:100%; border:2px solid #6a5acd; box-shadow:0 0 32px #6a5acd55;font-size: 14px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($pending)
            <div class="rpg-pending-box mb-3 p-3 text-center" style="background:rgba(106,90,205,0.15); border:1.5px solid #ffd700; border-radius:12px;">
                <div class="mb-2" style="font-size:2em;">🧙‍♂️</div>
                <strong style="color:#ffd700;">Top Up Request Pending Review</strong><br>
                <span style="color:#fff;">Package:</span> <span class="badge bg-warning text-dark">
                @if($pending->package=='random_box_20') 20 Random Box <span class='badge bg-info text-dark'>6h Shield</span> <span class='badge bg-success text-dark'>IDR 50,000</span>
                @elseif($pending->package=='treasure_40') 40 Treasure <span class='badge bg-info text-dark'>6h Shield</span> <span class='badge bg-success text-dark'>IDR 50,000</span>
                @elseif($pending->package=='random_box_40') 40 Random Box <span class='badge bg-info text-dark'>12h Shield</span> <span class='badge bg-success text-dark'>IDR 100,000</span>
                @elseif($pending->package=='treasure_80') 80 Treasure <span class='badge bg-info text-dark'>12h Shield</span> <span class='badge bg-success text-dark'>IDR 100,000</span>
                @else Unknown Package
                @endif
                </span><br>
                <span style="color:#fff;">Status:</span> <span class="badge bg-warning">Pending</span>
                <div class="mt-2" style="font-size:0.95em; color:#ccc;">If you already have shield, the duration will be added.</div>
                <div class="mt-2" style="font-size:0.95em; color:#ccc;">Please wait for admin approval before submitting another request.</div>
            </div>
        @else
            <form method="POST" action="{{ route('topup.store') }}" class="rpg-form" id="topupForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label" style="color:#ffd700; font-weight:bold;">Choose Package</label>
                    <div class="d-flex flex-column gap-2">
                        <div class="form-check rpg-radio">
                            <input class="form-check-input" type="radio" name="package" id="packageRandomBox" value="random_box_20" checked required>
                            <label class="form-check-label" for="packageRandomBox" style="color:#ffd700; font-weight:bold;">
                                🗃️ 20 Random Box <span class='badge bg-info text-dark'>+ 6h Shield</span> <span class='badge bg-success text-dark'>+ IDR 50,000</span>
                            </label>
                        </div>
                        <div class="form-check rpg-radio">
                            <input class="form-check-input" type="radio" name="package" id="packageTreasure" value="treasure_40" required>
                            <label class="form-check-label" for="packageTreasure" style="color:#ffd700; font-weight:bold;">
                                💎 40 Treasure <span class='badge bg-info text-dark'>+ 6h Shield</span> <span class='badge bg-success text-dark'>+ IDR 50,000</span>
                            </label>
                        </div>
                        <div class="form-check rpg-radio">
                            <input class="form-check-input" type="radio" name="package" id="packageRandomBox40" value="random_box_40" required>
                            <label class="form-check-label" for="packageRandomBox40" style="color:#ffd700; font-weight:bold;">
                                🗃️ 40 Random Box <span class='badge bg-info text-dark'>+ 12h Shield</span> <span class='badge bg-success text-dark'>+ IDR 100,000</span>
                            </label>
                        </div>
                        <div class="form-check rpg-radio">
                            <input class="form-check-input" type="radio" name="package" id="packageTreasure80" value="treasure_80" required>
                            <label class="form-check-label" for="packageTreasure80" style="color:#ffd700; font-weight:bold;">
                                💎 80 Treasure <span class='badge bg-info text-dark'>+ 12h Shield</span> <span class='badge bg-success text-dark'>+ IDR 100,000</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-2" style="font-size:0.95em; color:#ccc;">If you already have shield, the duration will be added.</div>
                </div>
                <button type="button" class="btn rpg-btn w-100" style="background:linear-gradient(90deg,#ffd700,#6a5acd); color:#232046; font-weight:bold; border-radius:8px; box-shadow:0 2px 8px #6a5acd55;" onclick="showTopupConfirm()">Submit Top Up</button>
            </form>
            <!-- Confirmation Modal -->
            <div class="modal fade" id="topupConfirmModal" tabindex="-1" aria-labelledby="topupConfirmLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background:#232046; color:#ffd700; border-radius:16px;">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="topupConfirmLabel">{{ __('topup.confirm') }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div style="font-size:2em;">⚠️</div>
                            <p>{{ __('topup.are_you_sure') }}</p>
                            <div class="mb-2" id="confirmAmountBox">
                                <span style="color:#fff; font-weight:bold;">{{ __('topup.amount') }}:</span> <span id="confirmAmount" class="badge bg-warning text-dark">50,000 IDR</span>
                            </div>
                            <div class="mb-2">
                                <span style="color:#fff; font-weight:bold;">{{ __('topup.package') }}:</span> <span id="confirmPackage" class="badge bg-primary"></span>
                            </div>
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('topup.cancel') }}</button>
                            <button type="button" class="btn btn-warning" onclick="submitTopupForm()">{{ __('topup.yes') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            function showTopupConfirm() {
                var pkg = document.querySelector('input[name="package"]:checked').value;
                var pkgText = '';
                var amountText = '';
                if(pkg === 'random_box_20') { pkgText = '🗃️ 20 Random Box + 6h Shield'; amountText = '50,000 IDR'; }
                else if(pkg === 'treasure_40') { pkgText = '💎 40 Treasure + 6h Shield'; amountText = '50,000 IDR'; }
                else if(pkg === 'random_box_40') { pkgText = '🗃️ 40 Random Box + 12h Shield'; amountText = '100,000 IDR'; }
                else if(pkg === 'treasure_80') { pkgText = '💎 80 Treasure + 12h Shield'; amountText = '100,000 IDR'; }
                else { pkgText = 'Unknown Package'; amountText = '-'; }
                document.getElementById('confirmPackage').textContent = pkgText;
                document.getElementById('confirmAmount').textContent = amountText;
                var modal = new bootstrap.Modal(document.getElementById('topupConfirmModal'));
                modal.show();
            }
            function submitTopupForm() {
                document.getElementById('topupForm').submit();
            }
            </script>
        @endif

        {{-- Player Top Up History --}}
        <div class="mt-4">
            <h4 class="mb-3" style="color:#ffd700; font-family:'Cinzel',serif;">{{ __('topup.your_top_up_history') }}</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-sm bg-dark text-light align-middle" style="border-radius:8px; overflow:hidden; min-width:320px;">
                    <thead>
                        <tr>
                            <th>{{ __('topup.package') }}</th>
                            <th>Cost</th>
                            <th>{{ __('topup.status') }}</th>
                            <th>{{ __('topup.requested_at') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\TopupRequest::where('user_id', Auth::id())->orderByDesc('created_at')->get() as $req)
                        <tr>
                            <td>
                            @if($req->package=='random_box_20') 20 Random Box
                            @elseif($req->package=='random_box_40') 40 Random Box
                            @elseif($req->package=='treasure_80') 80 Treasure
                            @else 40 Treasure
                            @endif
                            </td>
                            <td>
                            @if($req->package=='random_box_20' || $req->package=='treasure_40') <span class='badge bg-success text-dark'>IDR 50,000</span>
                            @elseif($req->package=='random_box_40' || $req->package=='treasure_80') <span class='badge bg-success text-dark'>IDR 100,000</span>
                            @else <span class='badge bg-secondary text-light'>Unknown</span>
                            @endif
                            </td>
                            <td>
                                @if($req->status=='pending')
                                    <span class="badge bg-warning">{{ __('topup.pending') }}</span>
                                @elseif($req->status=='success')
                                    <span class="badge bg-success">{{ __('topup.approved') }}</span>
                                @elseif($req->status=='rejected')
                                    <span class="badge bg-danger">{{ __('topup.rejected') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
