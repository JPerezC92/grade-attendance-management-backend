class StringValueObject:
    _value: str

    @property
    def value(self) -> str:
        return self._value

    def __init__(self, value: str):
        self._value = value

    def __eq__(self, other: 'StringValueObject') -> bool:
        return self._value == other._value
