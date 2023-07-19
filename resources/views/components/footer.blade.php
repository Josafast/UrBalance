<footer class="footer">
  <a href="https://josafast.github.io/JosafatPortofolio">
    <img src="{{ asset('img/jfastSFX.svg') }}" alt="Josafast_logo">
  </a>
  <p style="text-align: center;">{{ __('footer.copyright') }}<b class="year"></b></p>
  @auth
    <button id="change_balance" style="cursor: pointer; position: relative;">
      <img src="{{ asset('img/swap.svg') }}" alt="swap">
    </button>   
  @endauth
  <a href="https://github.io/Josafast"><img src="{{ asset('img/logo-github.svg') }}" alt="github_logo" style="width:30px;"></a>
</footer>
<script>
  let year = new Date().getFullYear();

  document.querySelector('.year').textContent = year;

  @auth
    document.getElementById('change_balance').addEventListener('click',()=>{
      document.getElementById('menu_balance').removeAttribute('style');
    });
  @endauth

  @if (auth()->check() AND (request()->routeIs('transactions.index') || !Illuminate\Support\Str::startsWith(Illuminate\Support\Facades\Route::currentRouteName(), 'transactions')))
    window.addEventListener('scroll',()=>{
      let footer = document.querySelector('.footer');
      let fixedObj = document.querySelector('.create_transaction');

      let footerTop = footer.getBoundingClientRect().top;

      if (footerTop <= window.innerHeight){
        fixedObj.style.bottom = `${30 + (window.innerHeight - footerTop)}px`;
      } else {
        fixedObj.style.bottom = "30px";
      }
    });
  @endif
</script>