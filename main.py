from typing import cast

import uvicorn
from asgiref.typing import ASGIApplication
from fastapi import FastAPI

from courses.infrastructure.course_routes import courses_router
from courses.infrastructure.courses_exception_handlers import courses_exception_handlers
from shared_kernel.infrastructure.database.connection import BaseDatabaseModel, engine
from shared_kernel.infrastructure.utils.register_exception_handlers import register_exception_handlers

BaseDatabaseModel.metadata.create_all(bind=engine)

app: FastAPI = FastAPI()

app.include_router(courses_router)

register_exception_handlers(app, [*courses_exception_handlers])


@app.get("/")
def read_root():
    return {"Hello": "World"}


if __name__ == "__main__":
    uvicorn.run(cast(ASGIApplication, app), host="0.0.0.0", port=8000)
