@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
    {{__('Dashboard/index.Billingmanagement')}}
@else
    {{__('Dashboard/index.Billingmanagement')}}
@endif
</a>
</td>
</tr>
