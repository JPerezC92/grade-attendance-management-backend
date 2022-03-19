from typing import Optional

from courses.domain.course import Course, CourseNotFound
from courses.domain.course_repository import CourseRepository
from shared_kernel.application.use_case import UseCase, Output


class SearchCourseById(UseCase[Course]):
    __course_repository: CourseRepository

    def __init__(self, course_repository: CourseRepository):
        self.__course_repository = course_repository

    def execute(self, course_id: str) -> Output:
        course: Optional[Course] = self.__course_repository.search_by_id(course_id)

        if course is None:
            raise CourseNotFound(course_id)

        return course
