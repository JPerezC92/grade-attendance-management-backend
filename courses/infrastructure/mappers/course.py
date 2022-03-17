from courses.domain.course import Course
from courses.infrastructure.response_models.course_response import CourseResponseModel


class CourseMapper:

    @staticmethod
    def to_response(course: Course) -> CourseResponseModel:
        return CourseResponseModel(
            id=course.id,
            name=course.name,
            description=course.description,
            is_active=course.is_active
        )
