@if (Visitors::firstHit())
    <script>
        var laravel_visitors_xhr = new XMLHttpRequest();

        laravel_visitors_xhr.open("POST", "{{ route('laravel-visitors.post') }}", true);
        laravel_visitors_xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        laravel_visitors_xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        laravel_visitors_xhr.send(
            "w=" + screen.width +
            "&h=" + screen.height +
            "&p=" + window.devicePixelRatio +
            "&c=" + screen.colorDepth +
            "&vw=" + window.innerWidth +
            "&vh=" + window.innerHeight +
            "&touch=" + (('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0)));
    </script>
@endif
