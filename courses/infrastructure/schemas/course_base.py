from typing import Optional

from pydantic import BaseModel


class CourseBase(BaseModel):
    name: str
    description: str
    is_active: Optional[bool]
