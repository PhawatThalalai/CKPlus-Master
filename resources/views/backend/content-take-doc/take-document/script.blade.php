<script>
    $(document).ready(function() {

        const progress = document.querySelector("#progress");
        const prev = document.querySelector("#prev");
        const next = document.querySelector("#next");
        const circles = document.querySelectorAll(".circle");
        const formStep = document.querySelectorAll(".step");
        const countdownEl = document.getElementById("countdownEl");
        let CONTNO = "";
        let typeLoan = "";
        let countdownInterval;

        let currentActive = 1;

        next.addEventListener("click", () => {
            currentActive++;

            if (currentActive > circles.length) {
                currentActive = circles.length;
            }
            update();
        });

        prev.addEventListener("click", () => {
            currentActive--;

            if (currentActive < 1) {
                currentActive = 1;
            }

            update();
        });

        function update() {
            switch(currentActive) {
                case 1: 
                    console.log("Step 1");
                    $(".step1").removeClass("visually-hidden");
                    $(".step2").addClass("visually-hidden");
                    $(".step3").addClass("visually-hidden");
                break;
                case 2:
                    console.log("Step 2");
                    loadTypeLoan();
                    $(".step1").addClass("visually-hidden");
                    $(".step2").removeClass("visually-hidden");
                    $(".step3").addClass("visually-hidden");
                break;
                case 3:
                    console.log("Step 3");
                    TakeDoc();
                    $(".step1").addClass("visually-hidden");
                    $(".step2").addClass("visually-hidden");
                    $(".step3").removeClass("visually-hidden");
                break;
            }

            circles.forEach((circle, idx) => {
                if (idx < currentActive) {
                    circle.classList.add("active");
                } else {
                    circle.classList.remove("active");
                }
            });

            const actives = document.querySelectorAll(".active");

            if (currentActive === 1) {
                prev.disabled = true;
            } else if (currentActive === circles.length) {
                next.disabled = true;
                // $("#next").submit();
            } else {
                prev.disabled = false;
                next.disabled = false;
            }
        }

        const TakeDoc = () => {
            try {
                let data = {
                    CONTNO: CONTNO,
                    docType: $("#docType").val(),
                    note: $("#NOTE").val(),
                    typeLoan: typeLoan,
                }

                $.ajax({
                    url: "{{ route('takeDoc.store') }}",
                    type: "POST",
                    data: {
                        page: 'takeDoc',
                        data: data,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        countdown(20, countdownEl);
                    },
                    error: function(err) {
                        clearInterval(countdownInterval);
                        currentActive--;
                        update();
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: 'เกิดข้อผิดพลาดกรุลองใหม่อีกครั้งภายหลัง',
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                });
            } catch (error) {
                currentActive--;
                update();
                clearInterval(countdownInterval);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    text: error,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }

        const loadTypeLoan = () => {
            try {
                let data = {
                    typeLoan: $("#Loans").val(),
                    CONTNO: $("#CONTNO").val(),
                };

                if (data.CONTNO === "" || data.typeLoan === "") {
                    throw "กรุณากรอกข้อมูลให้ครบ";
                }

                console.log(data);
                $.ajax({
                    url: "{{ route('takeDoc.index') }}",
                    type: "GET",
                    data: {
                        page: 'search',
                        data: data,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        CONTNO = data.body[0].CONTNO;
                        typeLoan = $("#Loans").val();
                        $("#CONTNOs").val(CONTNO);
                    },
                    error: function(err) {
                        currentActive--;
                        
                        update();
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: 'เกิดข้อผิดพลาดกรุณาตรวจสอบเลขสัญญาอีกครั้ง',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                });
            } catch (error) {
                currentActive--;
                        
                update();
                Swal.fire({
                    position: "center",
                    icon: "error",
                    text: error,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    });

    const countdown = (durationInSeconds, displayElement) => {
        timer = durationInSeconds;

        countdownInterval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            displayElement.textContent = minutes + ":" + seconds;
            countdownTime = minutes + ":" + seconds;
            console.log(`🎉 Countdown for your : ${countdownTime}`);

            if (--timer < 0) {
                window.location.href = "{{ route('view-backend.index') }}?page={{ 'list-take-document' }}";
            }
        }, 1000);
    }
</script>