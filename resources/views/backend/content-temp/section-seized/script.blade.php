<script>
    $('.btn-seized').click((e)=>{
        $('.showIcon').toggle()
        let id = $(e.currentTarget).attr('PactCon_id')
        let route = "{{ route('account.show',':ID') }}"
        let url = route.replace(':ID',id)
        $.ajax({
            url : url,
            type : 'GET',
            data : {
                 page : 'getSeized',
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : (res)=>{
                 $('.showIcon').toggle()
                 $('.modal').modal('hide')
                console.log(res);
                $('#form-seized').html(res.html)
                swal.fire({
                    icon : 'success',
                    title : 'สำเร็จ !',
                    text : 'เรียกข้อมูลสัญญาเรียบร้อย',
                    timer : 2000
                })
            },
            error : (err)=>{
                $('.showIcon').toggle()
                swal.fire({
                    icon : 'error',
                    title : 'ไม่สำเร็จ !',
                    text : 'เกิดข้อผิดพลาดในการเรียกข้อมูลสัญญาโปรดลองอีกครั้ง',
                    timer : 2000
                })
            }
        })
    })
</script>

<script>


function doAllWork() {
    $('.testProgress').css("width",2+"%").html(2+" %")

    let currentTime = 0;
    let i = 0 , sum = 0

    let randomNumberMax = Math.floor(Math.random() * 11) + 80 //80-90
    const interval =  1;


    const timer = setInterval(() => {

    const timeout = randomNumber = Math.floor(Math.random() * 50) + 50; // 50-100
        setTimeout(() => {
            currentTime += interval * 10;
            const progress = currentTime / 10;
            if (progress >= randomNumberMax) {
                const max = setInterval(() => {
                    sum = randomNumberMax + i
                    if(sum < 99){
                        $('.testProgress').css("width",(sum) +"%").html((sum) +" %")
                        console.log(sum);
                        i++;
                    }else{
                        clearInterval(max)
                    }
                },1000);

                clearInterval(timer);
                console.log('wait....');

            }else{
                $('.testProgress').css("width",(progress+sum)+"%").html((progress+sum)+" %")
            }
        }, timeout );


    }, interval * 100);

    return timer;
}

</script>

<script>
    $('.btn-getSeized').click((e)=>{
        const t = doAllWork();
        $('.showIcon').toggle()
        let id = $(e.currentTarget).attr('PactCon_id')
        let route = "{{ route('account.show',':ID') }}"
        let url = route.replace(':ID',id)
        $.ajax({
            url : url,
            type : 'GET',
            data : {
                 page : 'getSeizedFromSearch',
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : async (res)=>{
            clearInterval(t);
            $('.testProgress').css("width",100+"%").html(100+" %")

            console.log('ทำงานเสร็จสิ้น');
                 $('.showIcon').toggle()
                 $('#form-seized').html(res.html)
               await  swal.fire({
                     icon : 'success',
                     title : 'สำเร็จ !',
                     text : 'เรียกข้อมูลสัญญาเรียบร้อย',
                     timer : 2000
                    })
                    $('.testProgress').css("width",0+"%").html(0+" %")
                    $('.modal').modal('hide')
            },
            error : (err)=>{
                $('.showIcon').toggle()
                swal.fire({
                    icon : 'error',
                    title : 'ไม่สำเร็จ !',
                    text : 'เกิดข้อผิดพลาดในการเรียกข้อมูลสัญญาโปรดลองอีกครั้ง',
                    timer : 2000
                })
            }
        })
    })
</script>

<script>
    function validateForms(dataform) {
		var isvalid = false;
		Array.prototype.slice.call(dataform).forEach(function(form) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();

				form.classList.add('was-validated');

				isvalid = false;
			} else {
				isvalid = true;
			}
		});
		return isvalid;
	}
</script>
