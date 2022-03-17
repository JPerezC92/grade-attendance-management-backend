from pydantic import Field
from pydantic.dataclasses import dataclass


@dataclass
class CourseResponseModel:
    id: str = Field(..., title="Identifier", description="Course ID")
    name: str = Field(..., title="Name", description="Course name")
    description: str = Field(..., title="Description", description="Course description")
    is_active: bool = Field(..., title="Is active", description="Course is active")
