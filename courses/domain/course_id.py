from typing import Optional
from uuid import UUID, uuid4


class CourseId:
    __value: UUID

    @property
    def value(self) -> str:
        return str(self.__value)

    def __init__(self, value: Optional[str] = None):
        self.__value = UUID(value) if value else uuid4()

    def __eq__(self, other: 'CourseId') -> bool:
        return self.__value == other.value
