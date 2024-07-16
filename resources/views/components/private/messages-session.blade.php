@if (session()->has('error'))
{{ session()->get('error') }}
@elseif (session()->has('warning'))
{{ session()->get('warning') }}
@elseif (session()->has('success'))
{{ session()->get('success') }}
@endif
