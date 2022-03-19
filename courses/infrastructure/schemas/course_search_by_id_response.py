from pydantic import BaseModel

from courses.infrastructure.schemas.course import Course
from shared_kernel.infrastructure.response import Response


class SearchByIdRes(Response, BaseModel):
    course: Course
