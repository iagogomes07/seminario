from banco import supabase

def inserir():
    titulo = input("Título: ")
    descricao = input("Descrição: ")
    data_entrega = input("Data de entrega (AAAA-MM-DD): ")

    supabase.table("tarefas").insert({
        "titulo": titulo,
        "descricao": descricao,
        "data_entrega": data_entrega,
        "status": "pendente"
    }).execute()

    print("\nTarefa adicionada com sucesso!\n")


def listar():
    resultado = supabase.table("tarefas").select("*").execute()
    tarefas = resultado.data

    if not tarefas:
        print("\nNenhuma tarefa cadastrada.\n")
        return

    print("\n=== LISTA DE TAREFAS ===")

    for tarefa in tarefas:
        print(
            f"ID: {tarefa['id']} | "
            f"Título: {tarefa['titulo']} | "
            f"Descrição: {tarefa['descricao']} | "
            f"Data: {tarefa['data_entrega']} | "
            f"Status: {tarefa['status']}"
        )

    print()


def atualizar():
    id_tarefa = input("ID da tarefa: ")
    novo_status = input("Novo status: ")

    supabase.table("tarefas").update({
        "status": novo_status
    }).eq("id", id_tarefa).execute()

    print("\nStatus atualizado com sucesso!\n")


def excluir():
    id_tarefa = input("ID da tarefa: ")

    supabase.table("tarefas").delete().eq(
        "id",
        id_tarefa
    ).execute()

    print("\nTarefa excluída com sucesso!\n")


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


menu()