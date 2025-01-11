<div class="container" style="padding: 1rem; background: #f5f5f5;">
    <h2>Заказ №{{ $item->id }}</h2>
    @foreach ($entity as $field)
        @if ($field->type == 'relationship')
            @if ($field->relationship_count == 'single')
                @if (isset($field->value_title) && !empty($field->value_title))
                    <p>{{ $field->title }}: {{ $field->value_title }}</p>
                @endif
            @elseif($field->relationship_count == 'editable')
                <br>
                <h3>{{ $field->title }}</h3>
                @foreach ($field->value as $value)
                    @foreach ($value['fields'] as $valueField)
                        @if (!(isset($valueField->relationship_count) && ($valueField->relationship_count == 'single') && $valueField->relationship_table_name == 'orders') && $valueField->is_visible)
                            @if (isset($valueField->db_title) && $valueField->db_title == 'image')
                                <img src="{{ env('APP_URL').$valueField->value }}" style="width: 50px; height: 50px; object-fit: contain;" alt="">
                            @else
                                @if ((isset($valueField->relationship_count) && $valueField->relationship_count == 'single' && isset($valueField->value_title)))
                                    <p>{{ $valueField->title }}: {{ $valueField->value_title }}</p>
                                @else
                                    @if (!empty($valueField->value))
                                        <p>{{ $valueField->title }}: {{ $valueField->value }}</p>
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endforeach
                    <hr>
                @endforeach
            @endif
        @else
            @if (!empty($field->value) && $field->is_visible)
                <p>{{ $field->title }}: {{ $field->value }}</p>
            @endif
        @endif
    @endforeach
</div>