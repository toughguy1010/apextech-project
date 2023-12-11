<div class="modal fade " id="time_logs_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đăng ký vào / Đăng ký ra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="current-interface-timekeeping">
                    <div class="current-date">
                        {{ now()->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}
                    </div>
                </div>
                <div class="timekeeping-action">
                    <div id="checkin" class="btn btn-primary" data-url="{{ url('time/checkin') }}"
                        data-userID="{{ Auth::user()->id }}"
                        data-date="{{ now()->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}"
                        data-time="{{ now()->setTimezone('Asia/Ho_Chi_Minh')->toTimeString() }}">
                        Đăng kí vào
                    </div>
                    <div id="checkout" class="btn btn-primary" data-url="{{ url('time/checkout') }}"
                        data-userID="{{ Auth::user()->id }}"
                        data-date="{{ now()->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}"
                        data-time="{{ now()->setTimezone('Asia/Ho_Chi_Minh')->toTimeString() }}">
                        Đăng kí ra
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
