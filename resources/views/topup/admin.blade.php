@extends('layouts.app')
@section('content')
<style>
    .rpg-admin-bg {
        position: fixed;
        inset: 0;
        z-index: -1;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 25%, #0f3460 50%, #1a1a2e 75%, #16213e 100%);
        background-size: 400% 400%;
        animation: backgroundShift 20s ease-in-out infinite;
    }
    .rpg-admin-bg::before {
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
    .rpg-card-admin {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
        border: 2px solid rgba(59, 130, 246, 0.3);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 20px rgba(59,130,246,0.1);
        backdrop-filter: blur(8px);
        padding: 1.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .rpg-card-admin .rpg-title-admin {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #ffd700;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px #6a5acd;
        margin-bottom: 0.5rem;
    }
    .rpg-badge-admin {
        font-family: 'Orbitron', monospace;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 12px;
        padding: 0.5em 1em;
        margin: 0.2em;
        background: linear-gradient(90deg,#ffd700,#6a5acd);
        color: #232046;
        box-shadow: 0 2px 8px #6a5acd55;
        display: inline-block;
    }
    .rpg-table-admin th, .rpg-table-admin td {
        border: none;
        padding: 0.75em 0.5em;
        font-size: 1em;
        vertical-align: middle;
    }
    .rpg-table-admin thead {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
    }
    .rpg-table-admin tbody tr {
        background: rgba(30, 41, 59, 0.3);
        transition: all 0.3s ease;
    }
    .rpg-table-admin tbody tr:hover {
        background: rgba(59, 130, 246, 0.1);
        transform: scale(1.01);
    }
    @media (max-width: 768px) {
        .rpg-card-admin {
            padding: 1rem;
        }
        .rpg-title-admin {
            font-size: 1.3rem;
        }
        .rpg-table-admin th, .rpg-table-admin td {
            font-size: 0.95em;
            padding: 0.5em 0.3em;
        }
    }
    @media (max-width: 576px) {
        .rpg-card-admin {
            padding: 0.5rem;
        }
        .rpg-title-admin {
            font-size: 1.1rem;
        }
        .rpg-table-admin th, .rpg-table-admin td {
            font-size: 0.85em;
            padding: 0.3em 0.2em;
        }
    }
</style>
<div class="rpg-admin-bg"></div>
<div class="container pt-3">
    <h2 class="mb-4 rpg-title-admin text-center" style="color:white;">Player Top Up Request History</h2>

    @if(!empty($scoreboard))
    <div class="rpg-card-admin">
        <h4 class="rpg-title-admin text-center mb-2">Top Up Scoreboard</h4>
        <div class="table-responsive">
            <table class="table rpg-table-admin table-sm text-light align-middle" style="border-radius:8px; overflow:hidden; min-width:320px;">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Total Top Up</th>
                        <th>Approved Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($scoreboard as $entry)
                    <tr>
                        <td>{{ $entry['user']->name }}</td>
                        <td><span class="rpg-badge-admin">IDR {{ number_format($entry['total'], 0, ',', '.') }}</span></td>
                        <td><span class="rpg-badge-admin">{{ $entry['count'] }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @foreach($grouped as $userId => $requests)
        <div class="rpg-card-admin">
            <div class="mb-2 text-center">
                <span class="rpg-badge-admin">Total Approved Top Up: IDR {{ number_format($totals[$userId] ?? 0, 0, ',', '.') }}</span>
            </div>
            <h5 class="rpg-title-admin text-center mb-3">
                <i class="fas fa-user me-2"></i>{{ $requests->first()->user->name }}
            </h5>
            <div class="table-responsive">
                <table class="table rpg-table-admin table-sm text-light align-middle" style="border-radius:8px; overflow:hidden; min-width:320px;">
                    <thead>
                        <tr>
                            <th>Package</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Requested At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr>
                            <td>
                            @if($req->package=='random_box_20') <span class="rpg-badge-admin">🗃️ 20 Random Box <span class='badge bg-info text-dark'>6h Shield</span></span>
                            @elseif($req->package=='treasure_40') <span class="rpg-badge-admin">💎 40 Treasure <span class='badge bg-info text-dark'>6h Shield</span></span>
                            @elseif($req->package=='random_box_40') <span class="rpg-badge-admin">🗃️ 40 Random Box <span class='badge bg-info text-dark'>12h Shield</span></span>
                            @elseif($req->package=='treasure_80') <span class="rpg-badge-admin">💎 80 Treasure <span class='badge bg-info text-dark'>12h Shield</span></span>
                            @else <span class="rpg-badge-admin">Unknown Package</span>
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
                                    <span class="rpg-badge-admin" style="background:linear-gradient(90deg,#fbbf24,#f59e0b);color:#232046;">Pending</span>
                                @elseif($req->status=='success')
                                    <span class="rpg-badge-admin" style="background:linear-gradient(90deg,#10b981,#059669);color:#fff;">Approved</span>
                                @elseif($req->status=='rejected')
                                    <span class="rpg-badge-admin" style="background:linear-gradient(90deg,#dc2626,#991b1b);color:#fff;">Rejected</span>
                                @else
                                    <span class="rpg-badge-admin">{{ ucfirst($req->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $req->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i') }} <span class="text-muted" style="font-size:0.9em;">(UTC+7)</span></td>
                            <td>
                                @if($req->status=='pending')
                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                    <button type="button" class="btn btn-success btn-sm" onclick="showAdminConfirm('approve', {{ $req->id }}, '{{ $req->package }}')">Approve</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="showAdminConfirm('reject', {{ $req->id }}, '{{ $req->package }}')">Reject</button>
                                </div>
                                @else
                                <span class="rpg-badge-admin" style="background:linear-gradient(90deg,#10b981,#059669);color:#fff;">No Action</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

<!-- Admin Confirmation Modal -->
<div class="modal fade" id="adminConfirmModal" tabindex="-1" aria-labelledby="adminConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#232046; color:#ffd700; border-radius:16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="adminConfirmLabel">Confirm Action</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div style="font-size:2em;">⚠️</div>
                <p id="adminConfirmText"></p>
                <div class="mb-2">
                    <span style="color:#fff; font-weight:bold;">Package:</span> <span id="adminConfirmPackage" class="badge bg-primary"></span>
                </div>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <form id="adminConfirmForm" method="POST">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Yes, Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showAdminConfirm(action, id, pkg) {
    var modal = new bootstrap.Modal(document.getElementById('adminConfirmModal'));
    var text = action === 'approve' ? 'Are you sure you want to approve this top up request?' : 'Are you sure you want to reject this top up request?';
    document.getElementById('adminConfirmText').textContent = text;
    var pkgText = '';
    if(pkg === 'random_box_20') pkgText = '🗃️ 20 Random Box + 6h Shield + IDR 50,000';
    else if(pkg === 'treasure_40') pkgText = '💎 40 Treasure + 6h Shield + IDR 50,000';
    else if(pkg === 'random_box_40') pkgText = '🗃️ 40 Random Box + 12h Shield + IDR 100,000';
    else if(pkg === 'treasure_80') pkgText = '💎 80 Treasure + 12h Shield + IDR 100,000';
    else pkgText = 'Unknown Package';
    document.getElementById('adminConfirmPackage').textContent = pkgText;
    var form = document.getElementById('adminConfirmForm');
    if(action === 'approve') {
        form.action = '/topup/admin/approve/' + id;
    } else {
        form.action = '/topup/admin/reject/' + id;
    }
    modal.show();
}
</script>
@endsection
