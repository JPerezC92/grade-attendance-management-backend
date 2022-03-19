from typing import List, Optional

from sqlalchemy.orm import Session

from courses.domain.course import Course
from courses.domain.course_repository import CourseRepository
from courses.infrastructure.course_persistence import CoursePersistence
from courses.infrastructure.mappers.course_mapper import CourseMapper


class SqlAlchemyCourseRepository(CourseRepository):
    __database: Session

    def __init__(self, database: Session):
        self.__database = database

    def search_all(self) -> List[Course]:
        course_list: List[CoursePersistence] = self.__database.query(CoursePersistence).all()

        return [CourseMapper.from_persistence(course) for course in course_list]

    def search_by_id(self, identifier: str) -> Optional[Course]:
        course_persistence: Optional[CoursePersistence] = self.__database.query(CoursePersistence).filter(
            CoursePersistence.id == identifier).first()

        if course_persistence is not None:
            return CourseMapper.from_persistence(course_persistence)

    def persist(self, course: Course) -> Course:
        new_course_persistence = CoursePersistence(
            id=course.id,
            name=course.name,
            description=course.description,
            is_active=course.is_active
        )

        self.__database.add(new_course_persistence)

        return course

    def remove(self, course_id: str) -> None:
        self.__database.query(CoursePersistence).filter(CoursePersistence.id == course_id).delete()
