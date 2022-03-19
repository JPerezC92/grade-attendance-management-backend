from courses.domain.course import Course
from courses.domain.course_description import CourseDescription
from courses.domain.course_id import CourseId
from courses.domain.course_is_active import CourseIsActive
from courses.domain.course_name import CourseName
from courses.domain.course_repository import CourseRepository
from shared_kernel.application.use_case import UseCase, Output


class CourseCreator(UseCase[Course]):
    __course_repository: CourseRepository

    def __init__(self, course_repository: CourseRepository):
        self.__course_repository = course_repository

    def execute(self,
                name: CourseName,
                description: CourseDescription,
                is_active: CourseIsActive
                ) -> Output:
        course = Course(
            identifier=CourseId(),
            name=name,
            description=description,
            is_active=is_active
        )

        self.__course_repository.persist(course)

        return course
