<div style="max-height: 250px; overflow-y : scroll; overflow-x : hidden;">
    @for ($i = 0; $i < 5 ; $i++)
        <div class="card rounded border border-2 border-light mb-1 placeholder-glow">
            <div class="row p-2">
                <div class="col">
                    <p class="fw-semibold mb-0">   <span class="placeholder col-7"></span></p>
                    <sup class="fw-semibold text-secondary mb-0">   <span class="placeholder col-7"></span></sup>
                </div>
                <div class="col">
                    <p class="fw-semibold  text-end">   <span class="placeholder col-7"></span> </p>
                </div>
            </div>
        </div>
    @endfor
</div>