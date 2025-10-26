@extends('layouts.app')
@section('content')
<div class="rpg-topup-bg" style="position:fixed; inset:0; z-index:-1; background:radial-gradient(ellipse at top left, #6a5acd 0%, #1a1a2e 100%), url('/images/site/rpg-bg.png') center/cover no-repeat; opacity:0.7;"></div>
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height:80vh;">
    <div class="rpg-card shadow-lg p-4" style="background:rgba(34,30,60,0.95); border-radius:18px; max-width:420px; width:100%; border:2px solid #6a5acd; box-shadow:0 0 32px #6a5acd55;">
        <div class="text-center mb-4">
            <h2 class="rpg-title" style="color:#ffd700; font-family:'Cinzel',serif; letter-spacing:2px; text-shadow:0 2px 8px #6a5acd;">{{ __('topup.top_up') }}</h2>
            <div style="height:4px; width:80px; margin:0 auto; background:linear-gradient(90deg,#ffd700,#6a5acd); border-radius:2px;"></div>
        </div>
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
                <strong style="color:#ffd700;">{{ __('topup.top_up_request_pending_review') }}</strong><br>
                <span style="color:#fff;">{{ __('topup.package') }}:</span> <span class="badge bg-warning text-dark">@if($pending->package=='random_box') 20 Random Box @else 40 Treasure @endif + <span class='badge bg-info text-dark'>12h Shield</span></span><br>
                <span style="color:#fff;">{{ __('topup.status') }}:</span> <span class="badge bg-warning">Pending</span>
                <div class="mt-2" style="font-size:0.95em; color:#ccc;">{{ __('topup.each_package_include') }}</div>
                <div class="mt-2" style="font-size:0.95em; color:#ccc;">{{ __('topup.please_wait') }}</div>
            </div>
        @else
            <form method="POST" action="{{ route('topup.store') }}" class="rpg-form" id="topupForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label" style="color:#ffd700; font-weight:bold;"> {{ __('topup.choose_package') }} <span style="color:#fff;">(50,000 IDR)</span></label>
                    <div class="d-flex flex-column gap-2">
                        <div class="form-check rpg-radio">
                            <input class="form-check-input" type="radio" name="package" id="packageRandomBox" value="random_box" checked required>
                            <label class="form-check-label" for="packageRandomBox" style="color:#ffd700; font-weight:bold;">
                                🗃️ 20 {{ __('topup.random_box') }}
                            </label>
                        </div>
                        <div class="form-check rpg-radio">
                            <input class="form-check-input" type="radio" name="package" id="packageTreasure" value="treasure" required>
                            <label class="form-check-label" for="packageTreasure" style="color:#ffd700; font-weight:bold;">
                                💎 40 {{ __('topup.treasure') }}
                            </label>
                        </div>
                    </div>
                    <div class="mt-2" style="font-size:0.95em; color:#ccc;">{{ __('topup.each_package_include') }}</div>
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
                            <div class="mb-2">
                                <span style="color:#fff; font-weight:bold;">{{ __('topup.amount') }}:</span> <span class="badge bg-warning text-dark">50,000 IDR</span>
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
                var pkgText = pkg === 'random_box' ? '🗃️ 20 Random Box' : '💎 40 Treasure';
                document.getElementById('confirmPackage').textContent = pkgText;
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
                            <th>{{ __('topup.status') }}</th>
                            <th>{{ __('topup.requested_at') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\TopupRequest::where('user_id', Auth::id())->orderByDesc('created_at')->get() as $req)
                        <tr>
                            <td>@if($req->package=='random_box') 20 Random Box @else 40 Treasure @endif</td>
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
