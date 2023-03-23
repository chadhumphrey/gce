<html>
<head>
  @livewireStyles
  <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
      <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body data-new-gr-c-s-check-loaded>
  app blade
  @yield('content')
  <!-- livewireScripts -->
  <livewire:scripts />
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
  @livewireChartsScripts
</body>
</html>
