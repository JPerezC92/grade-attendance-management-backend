from typing import List

from courses.domain.course import Course
from courses.domain.course_repository import CourseRepository
from shared_kernel.application.use_case import UseCase, Output


class SearchAllCourses(UseCase[List[Course]]):
    __course_repository: CourseRepository

    def __init__(self, course_repository: CourseRepository):
        self.__course_repository = course_repository

    def execute(self) -> Output:
        course_list: List[Course] = self.__course_repository.search_all()

        return course_list
