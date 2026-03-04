<form method="{{ $spoofMethod ? 'POST' : $method }}" {!! $attributes !!}  @if(!$fullWidth)class="max-w-2xl"@endif>
    @unless(in_array($method, ['HEAD', 'GET', 'OPTIONS']))
        @csrf
    @endunless
    
    @if($spoofMethod)
        @method($method)
    @endif
    
        {!! $slot !!}
</form>