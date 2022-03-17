from shared_kernel.domain.value_bject.string_value_object import StringValueObject


class CourseDescription(StringValueObject):
    @staticmethod
    def change(course_description: str) -> 'CourseDescription':
        return CourseDescription(course_description)
