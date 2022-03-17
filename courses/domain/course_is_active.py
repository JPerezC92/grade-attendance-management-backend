from shared_kernel.domain.value_bject.bool_value_object import BoolValueObject


class CourseIsActive(BoolValueObject):

    @staticmethod
    def activate() -> 'CourseIsActive':
        return CourseIsActive(True)

    @staticmethod
    def deactivate() -> 'CourseIsActive':
        return CourseIsActive(False)
