from abc import abstractmethod, ABC


class DomainError(ABC, Exception):

    @abstractmethod
    def error_code(self) -> str:
        pass

    @abstractmethod
    def error_message(self) -> str:
        pass
