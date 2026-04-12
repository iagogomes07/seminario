import sqlite3
import os
import pytest

DB_TEST = "test_tarefas.db"


def setup_module():
    conn = sqlite3.connect(DB_TEST)
    cursor = conn.cursor()
    cursor.execute("""
    CREATE TABLE tarefas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        descricao TEXT,
        data_entrega TEXT NOT NULL,
        status TEXT NOT NULL
    )
    """)
    conn.commit()
    conn.close()


def teardown_module():
    if os.path.exists(DB_TEST):
        os.remove(DB_TEST)


def test_inserir_tarefa():
    conn = sqlite3.connect(DB_TEST)
    cursor = conn.cursor()

    cursor.execute("""
    INSERT INTO tarefas (titulo, descricao, data_entrega, status)
    VALUES ('Teste', 'Desc', '2026-05-10', 'pendente')
    """)

    conn.commit()

    cursor.execute("SELECT * FROM tarefas WHERE titulo = 'Teste'")
    tarefa = cursor.fetchone()

    conn.close()

    assert tarefa is not None


def test_titulo_vazio():
    conn = sqlite3.connect(DB_TEST)
    cursor = conn.cursor()

    with pytest.raises(sqlite3.IntegrityError):
        cursor.execute("""
        INSERT INTO tarefas (titulo, descricao, data_entrega, status)
        VALUES (NULL, 'Desc', '2026-05-10', 'pendente')
        """)

    conn.close()


def test_excluir_tarefa():
    conn = sqlite3.connect(DB_TEST)
    cursor = conn.cursor()

    cursor.execute("""
    INSERT INTO tarefas (titulo, descricao, data_entrega, status)
    VALUES ('Excluir', 'Desc', '2026-05-10', 'pendente')
    """)
    conn.commit()

    cursor.execute("SELECT id FROM tarefas WHERE titulo = 'Excluir'")
    tarefa_id = cursor.fetchone()[0]

    cursor.execute("DELETE FROM tarefas WHERE id = ?", (tarefa_id,))
    conn.commit()

    cursor.execute("SELECT * FROM tarefas WHERE id = ?", (tarefa_id,))
    tarefa = cursor.fetchone()

    conn.close()

    assert tarefa is None