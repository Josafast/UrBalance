@php
    $body = $labels->getData();

    $name = json_encode($body->name, true);
    $values = json_encode($body->data->transactions, true);
    $colors = json_encode($body->data->color, true);;
@endphp

<div class="chart-container">
    <canvas id="{{ $type }}"></canvas>
    <script>
        let {{ $type }} = document.getElementById("{{ $type }}");

        let string{{ $type }} = "{{ $name }}";
        string{{ $type }} = JSON.parse(string{{ $type }}.replace(/&quot;/g, '"'));

        let color{{ $type }} = "{{ $colors }}";
        color{{ $type }} = JSON.parse(color{{ $type }}.replace(/&quot;/g, '"'));
        color{{ $type }} = color{{ $type }}.map(color => rootStyles.getPropertyValue(`--${color}`));

        {{ $type }}.parentElement.setAttribute('data-content', "{{ $type }}");

        let data{{ $type }} = {
            labels: string{{ $type }},
            datasets: [{
                label: '{{ $type }}',
                data: {{ $values }},
                backgroundColor: color{{ $type }},
                borderColor: 'transparent'
            }]
        };

        new Chart({{ $type }}, {
            type: 'polarArea',
            data: data{{ $type }},
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    r: {
                        grid: {
                            color: '#ddd',
                            backgroundColor: 'transparent'
                        },
                        ticks: {
                            color: 'transparent'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                backgroundColor: 'transparent' // aquí establecemos el background transparente
            }
        });
    </script>
</div>