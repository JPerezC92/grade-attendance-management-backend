from courses.infrastructure.schemas.course_base import CourseBase


class Course(CourseBase):
    id: str

    class Config:
        orm_mode = True


