from fastapi import Depends
from sqlalchemy.orm import Session

from shared_kernel.infrastructure.database.get_database import get_database
from shared_kernel.infrastructure.database.uow import Uow


def get_uow(db: Session = Depends(get_database)):
    yield Uow(db)