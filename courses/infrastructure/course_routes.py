from typing import List

from fastapi import APIRouter, Depends, Body, status

from courses.application.course_creator import CourseCreator
from courses.application.course_remove import CourseRemove
from courses.application.search_all_courses import SearchAllCourses
from courses.application.search_course_by_id import SearchCourseById
from courses.domain.course import Course
from courses.domain.course_description import CourseDescription
from courses.domain.course_is_active import CourseIsActive
from courses.domain.course_name import CourseName
from courses.infrastructure.courses_responses import search_by_id_responses
from courses.infrastructure.repositories.sqlalchemy_course_repository import SqlAlchemyCourseRepository
from courses.infrastructure.schemas.course_create import CourseCreate
from courses.infrastructure.schemas.course_create_response import CourseCreateRes
from courses.infrastructure.schemas.course_search_all_response import SearchAllRes
from courses.infrastructure.schemas.course_search_by_id_response import SearchByIdRes
from shared_kernel.infrastructure.database.get_uow import get_uow
from shared_kernel.infrastructure.database.uow import Uow

courses_router: APIRouter = APIRouter(prefix="/courses", tags=["courses"])


@courses_router.get("/", response_model=SearchAllRes, status_code=status.HTTP_200_OK)
def search_all(uow: Uow = Depends(get_uow)):
    search_all_courses = SearchAllCourses(course_repository=SqlAlchemyCourseRepository(uow.db))

    course_list: List[Course] = uow.transaction(lambda: search_all_courses.execute())

    return {"status_code": status.HTTP_200_OK, "courses": course_list}


@courses_router.post("/", response_model=CourseCreateRes)
def create(course_create: CourseCreate = Body(...), uow: Uow = Depends(get_uow)):
    course_creator = CourseCreator(course_repository=SqlAlchemyCourseRepository(uow.db))

    course: Course = uow.transaction(lambda: course_creator.execute(
        name=CourseName(course_create.name),
        description=CourseDescription(course_create.description),
        is_active=CourseIsActive(course_create.is_active)
    ))

    return {"status_code": status.HTTP_201_CREATED, "course": course}


@courses_router.get("/{course_id}",
                    response_model=SearchByIdRes,
                    status_code=status.HTTP_200_OK,
                    responses=search_by_id_responses)
def search_by_id(course_id: str, uow: Uow = Depends(get_uow)):
    search_course_by_id = SearchCourseById(course_repository=SqlAlchemyCourseRepository(uow.db))

    course: Course = uow.transaction(lambda: search_course_by_id.execute(course_id=course_id))

    return {"status_code": status.HTTP_200_OK, "course": course}


@courses_router.delete("/{course_id}", status_code=status.HTTP_204_NO_CONTENT)
def delete(course_id: str, uow: Uow = Depends(get_uow)):
    course_remove = CourseRemove(course_repository=SqlAlchemyCourseRepository(uow.db))

    uow.transaction(lambda: course_remove.execute(course_id=course_id))
