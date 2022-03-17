class IntValueObject:
    _value: int

    @property
    def value(self) -> int:
        return self._value

    def __init__(self, value: int):
        self._value = value

    def __eq__(self, other: 'IntValueObject') -> bool:
        return self._value == other._value
