import sqlite3

DB_NAME = "tarefas.db"


def conectar():
    return sqlite3.connect(DB_NAME)


def inserir():
    titulo = input("Título da tarefa: ")
    descricao = input("Descrição: ")
    data = input("Data de entrega (YYYY-MM-DD): ")

    conn = conectar()
    cursor = conn.cursor()

    cursor.execute("""
    INSERT INTO tarefas (titulo, descricao, data_entrega, status)
    VALUES (?, ?, ?, ?)
    """, (titulo, descricao, data, "pendente"))

    conn.commit()
    conn.close()

    print("Tarefa adicionada com sucesso!\n")


def listar():
    conn = conectar()
    cursor = conn.cursor()

    cursor.execute("""
    SELECT id, titulo, data_entrega, status FROM tarefas
    ORDER BY data_entrega ASC
    """)

    tarefas = cursor.fetchall()
    conn.close()

    if not tarefas:
        print("Nenhuma tarefa cadastrada.\n")
        return

    print("\n=== LISTA DE TAREFAS ===")
    for t in tarefas:
        print(f"[{t[0]}] {t[1]} - {t[2]} ({t[3]})")
    print()


def atualizar():
    id_tarefa = input("ID da tarefa: ")

    conn = conectar()
    cursor = conn.cursor()

    cursor.execute("SELECT status FROM tarefas WHERE id = ?", (id_tarefa,))
    resultado = cursor.fetchone()

    if not resultado:
        print("Tarefa não encontrada!\n")
        conn.close()
        return

    novo_status = "concluido" if resultado[0] == "pendente" else "pendente"

    cursor.execute("""
    UPDATE tarefas SET status = ? WHERE id = ?
    """, (novo_status, id_tarefa))

    conn.commit()
    conn.close()

    print(f"Status atualizado para: {novo_status}\n")


def excluir():
    id_tarefa = input("ID da tarefa para excluir: ")

    conn = conectar()
    cursor = conn.cursor()

    cursor.execute("DELETE FROM tarefas WHERE id = ?", (id_tarefa,))

    conn.commit()
    conn.close()

    print("Tarefa excluída!\n")


def menu():
    while True:
        print("=== GERENCIADOR DE TAREFAS ===")
        print("1 - Inserir")
        print("2 - Listar")
        print("3 - Atualizar status")
        print("4 - Excluir")
        print("5 - Sair")

        opcao = input("Opção: ")

        if opcao == "1":
            inserir()
        elif opcao == "2":
            listar()
        elif opcao == "3":
            atualizar()
        elif opcao == "4":
            excluir()
        elif opcao == "5":
            print("Saindo...")
            break
        else:
            print("Opção inválida!\n")


if __name__ == "__main__":
    menu()