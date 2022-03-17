from typing import List

from pydantic import BaseModel, Field

from courses.infrastructure.response_models.course_response import CourseResponseModel


class GetCourseResponseModel(BaseModel):
    success: bool = True
    courses: List[CourseResponseModel] = Field(
        default_factory=CourseResponseModel,
        title="Courses",
        description="List of courses"
    )
