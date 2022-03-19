from pydantic import BaseModel

from courses.infrastructure.schemas.course import Course
from shared_kernel.infrastructure.response import Response


class CourseCreateRes(Response, BaseModel):
    course: Course


