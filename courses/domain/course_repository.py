from abc import ABC, abstractmethod
from typing import Optional

from courses.domain.course import Course


class CourseRepository(ABC):

    @abstractmethod
    def search_all(self) -> list[Course]:
        pass

    @abstractmethod
    def search_by_id(self, identifier: str) -> Optional[Course]:
        pass

    @abstractmethod
    def persist(self, course: Course) -> Course:
        pass

    @abstractmethod
    def remove(self, course_id: str) -> None:
        pass
