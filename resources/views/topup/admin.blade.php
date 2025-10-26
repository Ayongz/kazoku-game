@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Player Top Up Request History</h2>

    @if(!empty($scoreboard))
    <div class="mb-4">
        <h4 class="mb-2" style="color:#ffd700; font-family:'Cinzel',serif;">Top Up Scoreboard</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-sm bg-dark text-light align-middle" style="border-radius:8px; overflow:hidden; min-width:400px;">
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
                        <td><i class="fas fa-user me-2"></i>{{ $entry['user']->name }}</td>
                        <td><span class="badge bg-success">IDR {{ number_format($entry['total'], 0, ',', '.') }}</span></td>
                        <td>{{ $entry['count'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @foreach($grouped as $userId => $requests)
        <div class="mb-4 p-3" style="background:rgba(106,90,205,0.08); border-radius:12px; border:1.5px solid #6a5acd;">
            <div class="mb-2">
                <span class="badge bg-info text-dark">Total Approved Top Up: IDR {{ number_format($totals[$userId] ?? 0, 0, ',', '.') }}</span>
            </div>
            <h5 style="color:blue; font-family:'Cinzel',serif;">
                <i class="fas fa-user me-2"></i>{{ $requests->first()->user->name }}
            </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm bg-dark text-light align-middle" style="border-radius:8px; overflow:hidden; min-width:400px;">
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
                            <td>@if($req->package=='random_box') 20 Random Box @else 40 Treasure @endif</td>
                            <td><span class="badge bg-success">IDR {{ number_format(\App\Http\Controllers\TopupController::$PACKAGE_COST, 0, ',', '.') }}</span></td>
                            <td>
                                @if($req->status=='pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($req->status=='success')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($req->status=='rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($req->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $req->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i') }} <span class="text-muted" style="font-size:0.9em;">(UTC+7)</span></td>
                            <td>
                                @if($req->status=='pending')
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success btn-sm" onclick="showAdminConfirm('approve', {{ $req->id }}, '{{ $req->package }}')">Approve</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="showAdminConfirm('reject', {{ $req->id }}, '{{ $req->package }}')">Reject</button>
                                </div>
                                @else
                                <span class="badge bg-success">No Action</span>
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
    document.getElementById('adminConfirmPackage').textContent = pkg === 'random_box' ? '🗃️ 20 Random Box' : '💎 40 Treasure';
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
