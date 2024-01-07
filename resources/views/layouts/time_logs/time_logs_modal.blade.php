<style>
    .clock {
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.1);
        border: 2px solid rgba(0, 0, 0, 0.25);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .clock-container {
        position: relative;
    }

    .clock span {
        position: absolute;
        transform: rotate(calc(30deg * var(--i)));
        inset: 12px;
        text-align: center;
    }

    .clock span b {
        transform: rotate(calc(-30deg * var(--i)));
        display: inline-block;
        font-size: 20px;
    }

    .clock::before {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #fff;
        z-index: 2;
    }

    .hand {
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: flex-end;
    }

    .hand i {
        position: absolute;
        background-color: var(--clr);
        width: 4px;
        height: var(--h);
        border-radius: 8px;
    }
</style>
<div class="modal fade " id="time_logs_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đăng ký vào / Đăng ký ra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3 d-flex flex-column align-items-center">
                <div class="clock-container">
                    <div class="clock">
                        <div style="--clr: #ff3d58; --h: 74px" id="hour" class="hand">
                            <i></i>
                        </div>
                        <div style="--clr: #00a6ff; --h: 84px" id="min" class="hand">
                            <i></i>
                        </div>
                        <div style="--clr: #ffffff; --h: 94px" id="sec" class="hand">
                            <i></i>
                        </div>

                        <span style="--i: 1"><b>1</b></span>
                        <span style="--i: 2"><b>2</b></span>
                        <span style="--i: 3"><b>3</b></span>
                        <span style="--i: 4"><b>4</b></span>
                        <span style="--i: 5"><b>5</b></span>
                        <span style="--i: 6"><b>6</b></span>
                        <span style="--i: 7"><b>7</b></span>
                        <span style="--i: 8"><b>8</b></span>
                        <span style="--i: 9"><b>9</b></span>
                        <span style="--i: 10"><b>10</b></span>
                        <span style="--i: 11"><b>11</b></span>
                        <span style="--i: 12"><b>12</b></span>
                    </div>

                </div>
                <div class="current-interface-timekeeping">

                    <div class="current-date">
                        {{ now()->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}
                    </div>
                </div>
                <div class="timekeeping-action ">
                    @php
                        $checkin = \App\Models\TimeLog::where('user_id', Auth::user()->id)
                            ->where(
                                'date',
                                // now()->month(10)->year(2022)
                                now()
                                    ->setTimezone('Asia/Ho_Chi_Minh')
                                    ->toDateString(),
                            )
                            ->whereNotNull('check_in')
                            ->first();
                    @endphp
                
                    @if ($checkin)
                        {{-- Nếu đã đăng ký vào, hiển thị nút đăng ký ra --}}
                        @if (!$checkin->check_out)
                            <div id="checkout" class="btn btn-primary" data-url="{{ url('time/checkout') }}"
                                data-userID="{{ Auth::user()->id }}"
                                data-date="{{ now()->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}"
                                data-time="{{ now()->setTimezone('Asia/Ho_Chi_Minh')->toTimeString() }}">
                                Đăng kí ra
                            </div>
                        @endif
                    @else
                        {{-- Nếu chưa đăng ký vào, hiển thị nút đăng ký vào --}}
                        <div id="checkin" class="btn btn-primary" data-url="{{ url('time/checkin') }}"
                            data-userID="{{ Auth::user()->id }}"
                            data-date="{{ now()->setTimezone('Asia/Ho_Chi_Minh')->toDateString() }}"
                            data-time="{{ now()->setTimezone('Asia/Ho_Chi_Minh')->toTimeString() }}">
                            Đăng ký vào
                        </div>
                    @endif
                </div>
                
                @if ($checkin)
                    @if ($checkin->check_in)
                        <div class="time_log-history-checkin">
                            Đã đăng ký vào {{ $checkin->check_in }}
                        </div>
                    @endif
                    @if ($checkin->check_out)
                        <div class="time_log-history-checkout">
                            Đã đăng ký ra {{ $checkin->check_out }}
                        </div>
                    @endif
                @endif
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div class="message-report">
    <i class="fa-regular fa-bell me-2"></i>
</div>
<script>
    let hr = document.getElementById('hour');
    let min = document.getElementById('min');
    let sec = document.getElementById('sec');

    function displayTime() {
        let date = new Date();

        let hh = date.getHours();
        let mm = date.getMinutes();
        let ss = date.getSeconds();

        let hRotation = 30 * hh + mm / 2;
        let mRotation = 6 * mm;
        let sRotation = 6 * ss;

        hr.style.transform = `rotate(${hRotation}deg)`;
        min.style.transform = `rotate(${mRotation}deg)`;
        sec.style.transform = `rotate(${sRotation}deg)`;

    }

    setInterval(displayTime, 1000);
</script>
