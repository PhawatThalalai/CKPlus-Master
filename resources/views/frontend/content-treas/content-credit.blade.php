<div id="carouselExampleDark" class="carousel carousel-dark slide" >
    <div class="carousel-inner">
        @foreach(@$bankAccount as $item)
        <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
            @component('components.content-card.card-amount-treas')
            @slot('data',[
                'company_name' => @$item->company_bank,
                'Account_Bank' =>  @$item->Account_Bank,
                'Account_num' => @$item->Account_Number,
                'Amount_after' => @$item->BankToCredit->Amount_after == NULL ? 0 : @$item->BankToCredit->Amount_after,
                'Bankid' => @$item->id ,
                'BankZone' => @$item->User_Zone,
                'countBank' => count(@$bankAccount),
                'transaction' => @$item->BankToCreditMany,
            ])
            @endcomponent

        </div>
      @endforeach
    </div>
  </div>