<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="{{ mix('manuskript.css', 'vendor/manuskript') }}">
    <script src="{{ mix('manuskript.js', 'vendor/manuskript') }}" defer></script>
    @routes('manuskript')
</head>

<body>
    @inertia
</body>

</html>