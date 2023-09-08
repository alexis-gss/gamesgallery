@switch($type)
@case("boolean")
{{ boolval($data) ? "true" : "false" }}
@break
@case("integer")
{{ intval($data) }}
@break
@default
{{ $data }}
@endswitch
