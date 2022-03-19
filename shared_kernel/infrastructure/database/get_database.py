from sqlalchemy.orm import Session

from shared_kernel.infrastructure.database.connection import SessionLocal


def get_database():
    db: Session = SessionLocal()
    try:
        yield db
    finally:
        db.close()
