from courses.domain.course_repository import CourseRepository
from shared_kernel.application.use_case import UseCase


class CourseRemove(UseCase[None]):
    __course_repository: CourseRepository

    def __init__(self, course_repository: CourseRepository):
        self.__course_repository = course_repository

    def execute(self, course_id) -> None:
        self.__course_repository.remove(course_id)
