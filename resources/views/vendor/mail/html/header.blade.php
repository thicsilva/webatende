<tr>
    <td class="header">
        <a href="{{ $url }}">
            <img src="{{asset('images/logo.png')}}" alt="{{config('app.name')}}">
            {{ $slot }}
        </a>
    </td>
</tr>
