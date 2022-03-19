from typing import Callable, TypeVar

from sqlalchemy.orm import Session

OperationResult = TypeVar("OperationResult")


class Uow:
    __db: Session

    @property
    def db(self) -> Session:
        return self.__db

    def __init__(self, db: Session):
        self.__db = db

    def transaction(self, operation: Callable[[], OperationResult]) -> OperationResult:
        try:
            self.__db.begin()

            result = operation()

            self.__db.commit()

            return result
        except Exception as e:
            self.__db.rollback()
            raise e

        finally:
            self.__db.close()
