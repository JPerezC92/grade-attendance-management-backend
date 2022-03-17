from sqlalchemy import Column, Integer, String

from shared_kernel.infrastructure.database.connection import BaseDatabaseModel


class CourseDatabase(BaseDatabaseModel):
    __tablename__ = 'courses'

    id = Column(Integer, primary_key=True, index=True)
    name = Column(String)
    description = Column(String)
    is_active = Column(Integer, default=True)
