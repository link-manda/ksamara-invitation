@if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
    <script>
        document.addEventListener('alpine:initialized', function () {
            @if (session('success'))
                Flux.toast({
                    text: @json(session('success')),
                    variant: 'success',
                });
            @endif

            @if (session('error'))
                Flux.toast({
                    text: @json(session('error')),
                    variant: 'danger',
                });
            @endif

            @if (session('warning'))
                Flux.toast({
                    text: @json(session('warning')),
                    variant: 'warning',
                });
            @endif

            @if (session('info'))
                Flux.toast({
                    text: @json(session('info')),
                    variant: 'info',
                });
            @endif
        });
    </script>
@endif
