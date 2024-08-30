<style>
    :root {
        --bg-primary: #F5F5F5;
    }

    .main__card {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0px 250px 0 250px;
        padding: 20px 50px 20px 50px;
        border-radius: 10px;
        background: var(--bg-primary);
    }

    .btn__close {
        margin: 20px 0 0 0;
        display: block;
        background: #023047;
        border: none;
        border-radius: 5px;
        padding: 10px 30px 10px 30px;
        color: #F5F5F5;
        transition: 0.2s all ease-in-out;
    }

    .btn__close:hover {
        background: #231942;
    }
</style>
<div class="main__card">
    <div style="display: block;">
        <span>ไม่มีข้อมูลในวันที่สอบถามข้อมูล</span>
        <div style="display: flex; justify-content: center;">
            <button class="btn__close" onclick="handleClick()">Close</button>
        </div>
    </div>
</div>
<script>
    function handleClick() {
        window.close();
    }
</script>