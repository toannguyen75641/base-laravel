@php
    use App\Constants\BusinessUserConstant;
    use App\Helpers\ViewHelper;
@endphp

<select class="{{ $attributes['class'] . (isset($attributes['error']) ? " {$attributes['error']}" : '') }}" id="{{ $attributes['id'] }}" name="{{ $attributes['name'] }}">
    <option></option>
    @foreach($params['data'] as $item )
        <option value="{{ $item->id }}"
                {{ isset($params['condition']) ? ViewHelper::isSelected($params['condition'], $item->id, $params['key']) : '' }}
                {{ isset($params['parent_id']) ? "parent-id=".$item->{$params['parent_id']} : '' }}
                {{ isset($params['grand_parent_id']) ? "grand-parent-id=".$item->{$params['parent']}->{$params['grand_parent_id']} : '' }}
                {{ isset($params['great_grand_parent_id']) ? "great-grand-parent-id=".$item->{$params['great_grand_parent_id']} : '' }}
        >
            {{ isset($params['text']) ? $item->{$params['text']} : $item->name }}
        </option>
    @endforeach
</select>
