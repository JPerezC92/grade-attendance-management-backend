from fastapi import APIRouter, Depends
from pydantic import BaseModel, Field
from sqlalchemy.orm import Session

from courses.infrastructure.course_database_model import CourseDatabase
from shared_kernel.infrastructure.database.get_database import get_database

courses_router: APIRouter = APIRouter(prefix="/courses", tags=["courses"])


class Category(BaseModel):
    name: str


class Item(BaseModel):
    price: float
    category: list[Category] = Field(default_factory=Category)


# @courses_router.get("/", response_model=GetCourseResponseModel, )
# async def read_root():
#     c = Course(identifier="1", name=CourseName("Course 1"), description=CourseDescription("Course 1 description"),
#                is_active=CourseIsActive(True))
#
#     res: CourseResponseModel = CourseMapper.to_response(c)
#
#     return {"courses": [res]}


@courses_router.get("/", )
async def read_root(db: Session = Depends(get_database)):
    courses = db.query(CourseDatabase).all()

    return courses


@courses_router.post("/")
async def create_item(item: Item):
    print(item.dict())
    return {"item": item}
