class BoolValueObject:
    _value: bool

    @property
    def value(self) -> bool:
        return self._value

    def __init__(self, value: bool):
        self._value = value

    def __eq__(self, other: 'BoolValueObject') -> bool:
        return self._value == other.value
