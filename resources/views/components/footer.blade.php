<footer class="footer">
  <a href="https://josafast.github.io/JosafatPortofolio">
    <img src="{{ asset('img/jfastSFX.svg') }}" alt="Josafast_logo">
  </a>
  <p style="text-align: center;">{{ __('footer.copyright') }}<b class="year"></b></p>
  <a href="https://github.io/Josafast"><img src="{{ asset('img/logo-github.svg') }}" alt="github_logo" style="width:30px;"></a>
</footer>
<script>
  let year = new Date().getFullYear();

  document.querySelector('.year').textContent = year;

  @if (auth()->check() AND (request()->routeIs('transactions.index') || !Illuminate\Support\Str::startsWith(Illuminate\Support\Facades\Route::currentRouteName(), 'transactions')))
    window.addEventListener('scroll',()=>{
      if (window.innerWidth > 925){
        let footer = document.querySelector('.footer');
        let fixedObj = document.querySelector('.create_transaction');

        let footerTop = footer.getBoundingClientRect().top;

        if (footerTop <= window.innerHeight){
          fixedObj.style.bottom = `${30 + (window.innerHeight - footerTop)}px`;
        } else {
          fixedObj.style.bottom = "30px";
        }
      }
    });
  @endif
</script>