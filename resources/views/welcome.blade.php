<x-app-layout title="Bienvenido">
    <section class="index presentation" style="background: url('{{ asset('img/balance.jpg') }}') no-repeat center center scroll; background-size: cover;">
        <img src="{{ asset('img/balance-item.png') }}" alt="balancer" style="filter: invert(100%); flex-shrink: 1; max-width: 300px; max-height: 300px; margin-bottom: 20px;">
        <div style="display:flex; height: min-content; font-size: 2em;">
            <h1 style="transform: scaleX(-1);-moz-transform: scaleX(-1);-webkit-transform: scaleX(-1);-o-transform: scaleX(-1);font-weight:bold; color: #fff;">UR</h1>
            <h1 style="color: #fff !important; z-index: 11;">BALANCE</h1>
        </div>
        <h2 style="color: #fff; z-index: 11; margin: 0 40px; text-align: center; max-width: 340px;">Controla tus finanzas personales de manera rápida y precisa</h2>
    </section>
    <section class="index">
        <div style="flex-grow: 1;padding: 30px 90px; display: flex; align-items: center; justify-content: space-between;">
            <div style="max-width: 60vw">
                <p style="font-size: 1.5em; margin-bottom: 30px; max-width: 600px; margin-right: auto;">Ten control de tu economía en tu vida cotidiana y organízate según tus necesidades.</p>
                <p style="font-size: 1.5em; text-align:end; font-weight: bold; margin-left: auto;">Registra cada uno de los movimientos de tu dinero e inspecciona cuidadosamente tu próxima transacción.</p>
            </div>
            <img src="{{ asset('img/calculator.png') }}" alt="calculator" style="max-width: 300px;">
        </div>
        <div class="glide">
            <div class="glide__track" data-glide-el="track">
              <ul class="glide__slides">
                <li class="glide__slide"><div style="background-color: var(--red); color: #fff; padding: 30px 90px; display: flex;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">Gastos</h2>
                    <p style="font-size: 1.6em;">Usa tu dinero de forma meticulosa y señala porqué lo usaste. Filtra tus gastos según su categoría, e inspecciona tus patrones de gastos para tomar decisiones informadas sobre cómo manejar tus finanzas.</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/spends.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
                <li class="glide__slide"><div style="background-color: var(--yellow); color: #fff; padding: 30px 90px; display: flex;  align-content: center;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">Ahorros</h2>
                    <p style="font-size: 1.6em;">Lleva un conteo separado de tus transacciones cotidianas de lo que guardas y especifica el plazo en que usaras tus ahorros: Corto, medio o largo plazo. Así podrás establecer metas financieras y hacer un seguimiento de tu progreso hacia ellas.</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/savings.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
                <li class="glide__slide"><div style="background-color: var(--blue); color: #fff; padding: 30px 90px; display: flex;  align-content: center;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">Ingresos</h2>
                    <p style="font-size: 1.6em;">Es importante llevar un registro de tus ingresos para tener una visión completa de tu situación financiera. En tu página podrás registrar tus ingresos de diferentes fuentes, como salario, o el regalo de alguien más.</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/entrance.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
                <li class="glide__slide"><div style="background-color: var(--purple); color: #fff; padding: 30px 90px; display: flex;  align-content: center;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">Deudas y cobros</h2>
                    <p style="font-size: 1.6em;">También podrás llevar control de tus deudas y al tipo de entidad que debes. Así mismo, registra las deudas que terceros tienen contigo, para que puedas crear un plan de pagos a futuros y nada salga de tus manos.</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/deudas.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
                <li class="glide__slide"><div style="background-color: var(--green); color: #fff; padding: 30px 90px; display: flex; align-content: center;">
                    <div style="display: flex; flex-direction: column; justify-content: center; gap: 30px;">
                        <h2 style="font-weight: bold; font-size: 2.6em;">Notas</h2>
                    <p style="font-size: 1.6em;">Puedes tomar notas sobre cualquier otra información relevante para tu economía, como consejos que hayas recibido de un asesor financiero o cualquier otra información que quieras tener a mano para tomar decisiones informadas sobre el manejo de tu capital.</p>
                    </div>
                    <div style="width: 300px; height: 300px; flex-shrink: 0;">
                        <img src="{{ asset('img/notes.png') }}" alt="spends" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div></li>
              </ul>
            </div>
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><</button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">></button>
              </div>
          </div>
    </section>
    <section style="height: calc(100vh - 69px); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px;">
        <h1 style="font-weight: bold;">{{ auth()->check() ? 'Un momento... ¡Ya estás registrado!' : '¿Te gusta la idea?' }}</h1>
        <h1>{{auth()->check() ? 'Ve a ver tu dashboard y organizate' :'¡Registrate y comienza de una vez!'}}</h1>
        <a href="{{ route('register.view') }}" style="text-decoration: none; font-weight: bold; color: #000;">
            <button style="position: relative; margin-top: 10px; font-size: 1.3em;">
                {{auth()->check() ? 'Ver cuenta' :'Registrarse'}}
            </button>
        </a>    
    </section>
</x-app-layout>