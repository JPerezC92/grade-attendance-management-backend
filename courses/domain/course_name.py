from shared_kernel.domain.value_bject.string_value_object import StringValueObject


class CourseName(StringValueObject):

    @staticmethod
    def change(new_name: str) -> 'CourseName':
        return CourseName(value=new_name)
