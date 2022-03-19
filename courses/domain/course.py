from courses.domain.course_description import CourseDescription
from courses.domain.course_id import CourseId
from courses.domain.course_is_active import CourseIsActive
from courses.domain.course_name import CourseName
from shared_kernel.domain.DomainError import DomainError


class CourseNotFound(DomainError):
    __course_id: str

    def __init__(self, course_id: str):
        self.__course_id = course_id

    def error_code(self) -> str:
        return "course_not_found"

    def error_message(self) -> str:
        return f"Course with id {self.__course_id} not found"


class Course:
    __id: CourseId
    __name: CourseName
    __description: CourseDescription
    __is_active: CourseIsActive

    @property
    def id(self) -> str:
        return self.__id.value

    @property
    def name(self) -> str:
        return self.__name.value

    @property
    def description(self) -> str:
        return self.__description.value

    @property
    def is_active(self) -> bool:
        return self.__is_active.value

    def __init__(self,
                 identifier: CourseId,
                 name: CourseName,
                 description: CourseDescription,
                 is_active: CourseIsActive):
        self.__id = identifier
        self.__name = name
        self.__description = description
        self.__is_active = is_active

    def change_name(self, name: str) -> None:
        self.__name = self.__name.change(name)

    def change_description(self, new_description: str) -> None:
        self.__description = self.__description.change(new_description)

    def activate(self) -> None:
        self.__is_active = self.__is_active.activate()

    def deactivate(self) -> None:
        self.__is_active = self.__is_active.deactivate()
