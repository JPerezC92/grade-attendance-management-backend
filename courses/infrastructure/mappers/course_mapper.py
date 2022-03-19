from courses.domain.course import Course
from courses.domain.course_description import CourseDescription
from courses.domain.course_id import CourseId
from courses.domain.course_is_active import CourseIsActive
from courses.domain.course_name import CourseName
from courses.infrastructure.course_persistence import CoursePersistence
from courses.infrastructure.schemas.course_response import CourseResponseModel


class CourseMapper:

    @staticmethod
    def to_response(course: Course) -> CourseResponseModel:
        return CourseResponseModel(
            id=course.id,
            name=course.name,
            description=course.description,
            is_active=course.is_active
        )

    @staticmethod
    def from_persistence(course_persistence: CoursePersistence) -> Course:
        return Course(
            identifier=CourseId(course_persistence.id),
            name=CourseName(course_persistence.name),
            description=CourseDescription(course_persistence.description),
            is_active=CourseIsActive(course_persistence.is_active)
        )

    @staticmethod
    def to_persistence(course: Course) -> CoursePersistence:
        return CoursePersistence(
            id=course.id,
            name=course.name,
            description=course.description,
            is_active=course.is_active
        )
